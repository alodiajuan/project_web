<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        try {
            Log::info('User attempting to login', ['username' => $request->username]);

            $validator = Validator::make($request->all(), [
                'username' => 'required|numeric',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                Log::warning('Login validation failed', ['errors' => $validator->errors()]);

                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = User::where('username', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                Log::warning('Invalid login credentials', ['username' => $request->username]);

                return response()->json([
                    'status' => false,
                    'message' => 'Username atau password salah',
                ], 401);
            }

            if (!in_array($user->role, ['admin', 'dosen', 'tendik', 'mahasiswa'])) {
                Log::warning('Invalid role during login', ['username' => $request->username, 'role' => $user->role]);

                return response()->json([
                    'status' => false,
                    'message' => 'Role tidak valid',
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('User logged in successfully', ['user_id' => $user->id]);

            return response()->json([
                'status' => true,
                'message' => 'Login user berhasil',
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'nama' => $user->nama,
                        'role' => $user->role,
                        'foto_profile' => $user->foto_profile ? url('images/profile/1729775674.png') : null,
                        'semester' => $user->semester,
                        'id_kompetensi' => $user->id_kompetensi,
                        'id_prodi' => $user->id_prodi,
                        'alfa' => $user->alfa,
                        'compensation' => $user->compensation
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error during login', [
                'username' => $request->username,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // Logout
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                $userId = $user->id;
                Log::info('User attempting to logout', ['user_id' => $userId]);

                $user->currentAccessToken()->delete();

                Log::info('User logged out successfully', ['user_id' => $userId]);

                return response()->json([
                    'status' => true,
                    'message' => 'Logout user berhasil',
                ]);
            }

            Log::warning('Unauthenticated logout attempt', ['ip' => $request->ip()]);

            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        } catch (\Exception $e) {
            Log::error('Error during logout', [
                'user_id' => $request->user() ? $request->user()->id : null,
                'ip' => $request->ip(),
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Logout failed',
            ], 500);
        }
    }

    // User Profile
    public function userProfile(Request $request)
    {
        try {

            //  user terautentikasi menggunakan token Sanctum
            if (!auth()->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $user = auth()->user();

            // Jika user tidak ditemukan, beri respons kesalahan
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Get data profile berhasil',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'role' => $user->role,
                    'foto_profile' => $user->foto_profile ? url('images/profile/1729775674.png') : null,
                    'semester' => $user->semester ?? null,
                    'id_kompetensi' => $user->id_kompetensi ?? null,
                    'id_prodi' => $user->id_prodi ?? null,
                    'alfa' => $user->alfa ?? null,
                    'compensation' => $user->compensation ?? null,
                ]
            ]);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Tangani kesalahan autentikasi secara spesifik
            Log::error('Authentication Error', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Authentication failed. Please log in again.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Exception $e) {
            // Tangani kesalahan umum lainnya
            Log::error('Error fetching user profile', [
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'There was an error fetching user profile data',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            // Tangani kesalahan autentikasi secara spesifik
            Log::error('Authentication Error', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Authentication failed. Please log in again.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Exception $e) {
            Log::error('Error fetching user profile', [
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'There was an error fetching user profile data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

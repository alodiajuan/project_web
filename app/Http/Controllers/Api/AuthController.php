<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required|string|min:6',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }
    
            $user = User::where('username', $request->username)->first();
    
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                        'nama' => $user->nama,
                        'role' => $user->role,
                    ],
                    'token' => $token,
                ],
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        try {
            if ($request->user()) {
                $userId = $request->user()->id; 
                $request->user()->currentAccessToken()->delete();

                Log::info('User logged out successfully', ['user_id' => $userId]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Logout user successfully'
                ])->header('Content-Type', 'application/json');
            }

            Log::warning('Unauthenticated user attempted to logout', ['ip' => $request->ip()]);

            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated'
            ], 401);
        } catch (\Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage(), [
                'user_id' => $request->user() ? $request->user()->id : null,
                'ip' => $request->ip(),
                'error_trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Logout failed'], 500);
        }
    }

    // User Profile
    public function userProfile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'foto_profile' => $user->foto_profile ?? null,
                'nama' => $user->nama,
                'semester' => $user->semester,
                'id_kompetensi' => $user->id_kompetensi,
                'id_prodi' => $user->id_prodi,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ]);
    }
}

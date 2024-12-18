<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MahasiswaModel;
use App\Models\SdmModel;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:Mahasiswa,Dosen', // Only two roles: Mahasiswa and Dosen
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = $request->input('role');
        $credentials = [
            'password' => $request->password
        ];

        // Determine guard and username field based on role
        if ($role === 'Mahasiswa') {
            $guard = 'mahasiswa';
            $credentials['nim'] = $request->username; // Username for Mahasiswa is NIM
        } else {
            $guard = 'sdm'; // Dosen uses guard 'sdm'
            $credentials['nip'] = $request->username; // Username for Dosen is NIP
        }

        // Attempt to login with the appropriate guard
        if (!$token = auth()->guard($guard.'_api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau Password Anda salah'
            ], 401);
        }

        // Get user data
        $user = auth()->guard($guard.'_api')->user();

        // Prepare response data
        $userData = [
            'id' => $guard === 'mahasiswa' ? $user->nim : $user->nip,
            'username' => $guard === 'mahasiswa' ? $user->nim : $user->username,
            'name' => $guard === 'mahasiswa' ? $user->mahasiswa_nama : $user->sdm_nama,
            'role' => $role
        ];

        // Redirect logic for Dosen (sdm) role
        if ($role === 'Dosen') {
            if ($user->level_nama === 'dosen') {
                $userData['redirect_to'] = 'berandadosen'; // Add redirect information
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak memiliki akses sebagai dosen',
                ], 403);
            }
        }

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Login Berhasil',
            'user' => $userData,
            'token' => $token
        ], 200);
    }
}

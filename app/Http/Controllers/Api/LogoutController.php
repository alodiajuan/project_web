<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;


class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        if ($removeToken) {
            // return response JSON
            return response()->json([
                'success'   => true,
                'message'   => 'Logout Berhasil',
            ]);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validator->errors()
            ], 400);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::once($credentials)) {
            return response()->json([
                'success' => 0,
                'errorcode' => 2,
                'message' => 'Unauthorized user.'
            ], 401);
        }
        $user = Auth::user();
        $accessToken = $user->createToken('Token')->plainTextToken;
        
        return response()->json([
            'success' => 0,
            'access_token' => $accessToken,
            'login_user' => $user,
            'message' => 'Login success.'
        ], 200);
    }

    public function check(Request $request) {
        return response()->json([
            'success' => 0,
            'login_user' => $request->user(),
            'message' => 'Login now.'
        ], 200);
    }

    public function logout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'success' => 0,
            'logout_user' => $user,
            'message' => 'logout success.'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) : JsonResponse{
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('name', $request->name)->first(); 

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors'=> [
                    'name' => ['The provided credentials are incorrect.'],
                ]
            ], 402);
        }
        return response()->json([
            'session' => 'success',
            'message' => 'Logged in successfully.',
            'token' => $user->createToken($request->device_name)->plainTextToken
        ], 200);
    }

    public function logout() : JsonResponse{
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'session' => 'success',
            'message' => 'Logged out successfully.'
        ], 200);
    }
}

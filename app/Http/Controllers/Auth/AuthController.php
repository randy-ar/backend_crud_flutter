<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            throw ValidationException::withMessages([
                'name' => ['The provided credentials are incorrect.'],
            ]);
        }
        return response()->json([
            'session' => 'success',
            'message' => 'Logged in successfully.',
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}

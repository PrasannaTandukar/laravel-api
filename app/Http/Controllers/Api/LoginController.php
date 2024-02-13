<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiTrait;
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->errorResponse([], 'Invalid username or password.', 401);
            }

            $user = Auth::user();
            $data = [
                'token' => $user->createToken('secret-key')->plainTextToken
            ];

            return $this->successResponse($data, 'Login successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse([], 'Server Error.', 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse([], 'Logout successful', 200);
        } catch (\Exception $exception) {
            return $this->errorResponse([], 'Server Error.', 500);
        }
    }
}

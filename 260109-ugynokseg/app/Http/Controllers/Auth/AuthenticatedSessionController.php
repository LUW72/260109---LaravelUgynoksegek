<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        // Breeze LoginRequest validál + Auth::attempt belül
        $request->authenticate();

        $user = $request->user();

        // opcionális: régi tokenek törlése (ha 1 token / user kell)
        // $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user,
            'status'       => 'Login successful',
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        // ha Bearer tokennel jössz, ez létezni fog
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}

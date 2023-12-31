<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticatedTokenController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();

        $token = $user->createToken($request->token_name ?? 'user_authentication');
        
        return response()->json([
            'message' => 'user authentication successfull',
            'token'   => $token->plainTextToken,
            'user'    => $user,
        ],200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'successfully logout',
        ],200);
    }
}

<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $user = User::query()->where('email', $request->string('email'))->firstOrFail();

        $token = $user->createToken(
            'login-' . Str::random(16),
            expiresAt: $request->boolean('remember') ? now()->addWeek() : now()->addDay()
        );

        return response()->json([
            'token' => [
                'value' => $token->plainTextToken,
                'type' => 'Bearer',
                'expires_at' => $token->accessToken->expires_at,
            ],
            'user' => (new UserResource($user))->toArray($request),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}

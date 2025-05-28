<?php

namespace Modules\Auth\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Auth\Enums\Role;
use Modules\Auth\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::query()->where('email', $request->string('email'))->firstOrFail();

        if ($user->hasAnyRole([Role::SuperAdmin, Role::Admin, Role::Teacher])) {
            return Inertia::location(route('filament.admin.pages.dashboard'));
        }

        return Inertia::location(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

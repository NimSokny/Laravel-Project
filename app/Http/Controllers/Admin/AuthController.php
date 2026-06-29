<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'The email or password is incorrect.'])
                ->onlyInput('email');
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'This account does not have admin access.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Revoke all API tokens for the user to logout from frontend
        if ($user) {
            $user->tokens()->delete();
        }

        return redirect('http://localhost:5173/')->with('success', 'You have been logged out.');
    }

    public function tokenLogin(Request $request): RedirectResponse
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('admin.auth.login')
                ->withErrors(['email' => 'Token is required.']);
        }

        // Find user by API token
        $tokenModel = \Laravel\Sanctum\PersonalAccessToken::findToken($token);

        if (!$tokenModel) {
            return redirect()->route('admin.auth.login')
                ->withErrors(['email' => 'Invalid token.']);
        }

        $user = $tokenModel->tokenable;

        if (!$user || !$user->isAdmin()) {
            return redirect()->route('admin.auth.login')
                ->withErrors(['email' => 'This account does not have admin access.']);
        }

        // Log in the user via session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function apiLogin(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'The email or password is incorrect.'
            ], 401);
        }

        if (! Auth::user()->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => false,
                'message' => 'This account does not have admin access.'
            ], 403);
        }

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => Auth::user()
        ]);
    }

    public function apiLogout(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'You have been logged out.'
        ]);
    }

    public function apiUser(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        if (! Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'This account does not have admin access.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'user' => Auth::user()
        ]);
    }
}


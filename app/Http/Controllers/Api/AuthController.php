<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'                  => ['required', 'string', 'max:255'],
                'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
                'password'              => ['required', 'confirmed', Password::defaults()],
                'phone'                 => ['nullable', 'string', 'max:20'],
                'address'               => ['nullable', 'string'],
                'profile_image'         => ['nullable', 'image', 'max:5120'],
            ]);

            // Get or create customer role
            $customerRole = \App\Models\Role::firstOrCreate(
                ['name' => 'customer'],
                ['name' => 'customer']
            );

            $profileImagePath = null;
            if ($request->hasFile('profile_image')) {
                $profileImagePath = $request->file('profile_image')->store('profile-images', 'public');
            }

            $user = User::create([
                'role_id'       => $customerRole->id,
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'password'      => $validated['password'],
                'phone'         => $validated['phone'] ?? null,
                'address'       => $validated['address'] ?? null,
                'profile_image' => $profileImagePath,
            ]);

            $token = $user->createToken('api')->plainTextToken;

            return $this->success([
                'user'  => $user,
                'token' => $token,
            ], 'Registration successful', 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! \Auth::attempt($validated)) {
            return $this->error('The email or password is incorrect.', 401);
        }

        $user = \Auth::user()->load('role');
        $token = $user->createToken('api')->plainTextToken;

        // Keep session alive for admin users to access admin dashboard
        if (!$user->isAdmin()) {
            \Auth::logout();
        }

        return $this->success([
            'user'  => $user,
            'token' => $token,
        ], 'Login successful');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logged out successfully');
    }

    public function profile(Request $request): JsonResponse
    {
        return $this->success($request->user()->load('role'), 'Profile retrieved');
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        $request->user()->update($validated);

        return $this->success($request->user(), 'Profile updated');
    }

    public function createAdminSession(Request $request): JsonResponse
    {
        $user = $request->user()->load('role');

        if (!$user->isAdmin()) {
            return $this->error('This account does not have admin access.', 403);
        }

        // Log in the user via session for admin dashboard access
        \Auth::login($user);
        $request->session()->regenerate();

        return $this->success(null, 'Admin session created');
    }
}

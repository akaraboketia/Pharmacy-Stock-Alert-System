<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,pharmacist,staff',
        ]);

        // Make login case-insensitive by converting username to lowercase
        $credentials['username'] = strtolower($credentials['username']);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Validate that the selected role matches the user's actual role
            if ($user->role !== $request->role) {
                Auth::logout();
                $request->session()->regenerate();
                return back()->withErrors([
                    'role' => 'The selected role does not match this account. Please choose the correct role.',
                ])->onlyInput('username');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . $user->username . '!');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|exists:users,username',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['username' => $request->username],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        return redirect()->route('password.reset', ['token' => $token])
            ->with('success', 'Password reset link generated. You can now reset your password.');
    }

    public function showResetForm(string $token): View|RedirectResponse
    {
        $record = DB::table('password_resets')->where('token', $token)->first();

        if (!$record) {
            return redirect()->route('login')
                ->with('error', 'Invalid or expired password reset token.');
        }

        return view('auth.reset-password', ['token' => $token, 'username' => $record->username]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'username' => 'required|exists:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('username', $request->username)
            ->first();

        if (!$record) {
            return back()->withErrors(['username' => 'Invalid or expired password reset token.']);
        }

        // Check token expiration (60 minutes)
        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->copy()->addMinutes(60)->isPast()) {
            DB::table('password_resets')->where('username', $request->username)->delete();
            return back()->withErrors(['username' => 'Password reset token has expired. Please request a new one.']);
        }

        $user = \App\Models\User::where('username', $request->username)->first();
        $user->update(['password' => $request->password]);

        DB::table('password_resets')->where('username', $request->username)->delete();

        return redirect()->route('login')
            ->with('success', 'Password reset successfully. Please sign in with your new password.');
    }
}

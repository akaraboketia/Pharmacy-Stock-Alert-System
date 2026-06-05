<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [
            'low_stock_threshold' => 10,
            'expiry_warning_days' => 30,
            'default_theme' => 'light',
            'alert_notifications' => true,
        ];

        return view('settings.index', compact('user', 'preferences'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->user_id . ',user_id'],
        ]);

        $user->update(['username' => $validated['username']]);

        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Current password is incorrect.');
                    }
                }],
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user->update(['password' => Hash::make($request->new_password)]);
        }

        return redirect()->route('settings.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'low_stock_threshold' => ['required', 'integer', 'min:1', 'max:999'],
            'expiry_warning_days' => ['required', 'integer', 'min:1', 'max:365'],
            'default_theme' => ['required', 'in:light,dark'],
            'alert_notifications' => ['nullable', 'boolean'],
        ]);

        $validated['alert_notifications'] = $request->has('alert_notifications');

        $user->update(['preferences' => $validated]);

        return redirect()->route('settings.index')->with('success', 'Preferences saved successfully.');
    }
}

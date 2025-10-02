<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the tenant login form.
     */
    public function showLoginForm(Request $request)
    {
        $tenant = $request->route('tenant');

        return view('tenant.auth.login', compact('tenant'));
    }

    /**
     * Handle a login request for the tenant application.
     */
    public function login(Request $request)
    {
        $tenantId = tenant('id') ?? $request->route('tenant');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['tenant_id'] = $tenantId;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('tenant.dashboard', [
                'tenant' => $tenantId,
            ]);
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials.',
            ])
            ->onlyInput('email');
    }

    /**
     * Log the tenant user out of the application.
     */
    public function logout(Request $request)
    {
        $tenant = tenant('id') ?? $request->route('tenant');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant.login', ['tenant' => $tenant]);
    }
}

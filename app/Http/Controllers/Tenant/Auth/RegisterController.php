<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Display the tenant registration form.
     */
    public function showRegistrationForm(Request $request)
    {
        $tenant = $request->route('tenant');

        return view('tenant.auth.register', compact('tenant'));
    }

    /**
     * Handle the tenant registration request.
     */
    public function register(Request $request)
    {
        $tenantId = tenant('id') ?? $request->route('tenant');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->where(
                    fn ($query) => $query->where('tenant_id', $tenantId)
                ),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'tenant_id' => $tenantId,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('tenant.dashboard', ['tenant' => $tenantId]);
    }
}

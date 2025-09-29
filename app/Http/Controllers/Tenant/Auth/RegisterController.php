<?php

namespace App\Http\Controllers\Tenant\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        return view('tenant.auth.register');
    }

    /**
     * Traite la demande d'inscription
     */
    public function register(Request $request)
    {
        $tenantId = $request->route('tenant');

        $request->validate([
            'name'     => ['required','string','max:255'],
            // ⬇️ unicité par tenant_id (composite)
            'email'    => [
                'required','email','max:255',
                Rule::unique('users','email')->where(fn($q) => $q->where('tenant_id', tenant('id') ?? $tenantId)),
            ],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            // 'tenant_id' sera auto-renseigné par le trait BelongsToTenant si tenancy est initialisée par path
        ]);

        Auth::login($user);

        return redirect()->route('tenant.dashboard', ['tenant' => $tenantId]);
    }
}

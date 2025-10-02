<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::all();

        return view('tenant.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de crÃ©ation d'un utilisateur.
     */
    public function create()
    {
        return view('tenant.users.create');
    }

    /**
     * Enregistre un nouvel utilisateur.
     */
    public function store(Request $request)
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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenantId,
        ]);

        return redirect()->route('users.index', ['tenant' => $tenantId])
            ->with('success', 'Utilisateur crÃ©Ã© avec succÃ¨s');
    }

    /**
     * Affiche les dÃ©tails d'un utilisateur.
     */
    public function show(User $user)
    {
        return view('tenant.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'Ã©dition d'un utilisateur.
     */
    public function edit(User $user)
    {
        return view('tenant.users.edit', compact('user'));
    }

    /**
     * Met Ã  jour un utilisateur.
     */
    public function update(Request $request, User $user)
    {
        $tenantId = tenant('id') ?? $request->route('tenant');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->where(fn ($query) => $query->where('tenant_id', $tenantId))
                    ->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index', ['tenant' => $tenantId])
            ->with('success', 'Utilisateur mis Ã  jour avec succÃ¨s');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(Request $request, User $user)
    {
        $tenantId = tenant('id') ?? $request->route('tenant');

        $user->delete();

        return redirect()->route('users.index', ['tenant' => $tenantId])
            ->with('success', 'Utilisateur supprimÃ© avec succÃ¨s');
    }
}

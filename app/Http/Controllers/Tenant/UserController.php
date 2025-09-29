<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        $users = User::all();
        return view('tenant.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur
     */
    public function create()
    {
        return view('tenant.users.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required','string','max:255'],
            // ⬇️ unicité par tenant, comme dans RegisterController
            'email'    => [
                'required','email','max:255',
                \Illuminate\Validation\Rule::unique('users','email')->where(fn($q) => $q->where('tenant_id', tenant('id') ?? $request->route('tenant'))),
            ],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index', ['tenant' => $request->route('tenant')])
            ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('tenant.users.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'édition d'un utilisateur
     */
    public function edit(User $user)
    {
        return view('tenant.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => [
                'required','email','max:255',
                \Illuminate\Validation\Rule::unique('users','email')
                    ->where(fn($q) => $q->where('tenant_id', tenant('id') ?? $request->route('tenant')))
                    ->ignore($user->id),
            ],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        $userData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index', ['tenant' => $request->route('tenant')])
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('users.index', ['tenant' => $request->route('tenant')])
            ->with('success', 'Utilisateur supprimé avec succès');
    }
}

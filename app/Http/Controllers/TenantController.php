<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;
class TenantController extends Controller
{
    /**
     * Affiche la liste des tenants
     */
    public function index()
    {
        // En path-mode, la relation domains n’est pas nécessaire
        $tenants = collect();
        try {
            $tenants = Tenant::query()->get();
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des tenants: ' . $e->getMessage());
        }
        return view('tenants.index', compact('tenants'));
    }

    /**
     * Affiche le formulaire de création d'un tenant
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * Enregistre un nouveau tenant
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|alpha_dash|max:50|unique:tenants,id',
        ]);

        // Création du tenant
        $tenant = Tenant::create([
            'id' => $request->subdomain,
            'name' => $request->name,
        ]);




        return redirect()->route('tenant.login', ['tenant' => $tenant->id])
    ->with('success', 'Tenant créé. Connectez-vous à votre espace.');
    }


}

<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le dashboard du tenant
     */
    public function index()
    {
        $user = Auth::user();
        $tenant = tenant();

        return view('tenant.dashboard', compact('user', 'tenant'));
    }
}

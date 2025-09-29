<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        if ($tenant = $request->route('tenant')) {
            return route('tenant.login', ['tenant' => $tenant]);
        }

        // Pas d'auth centrale : on renvoie vers la liste publique des tenants
        return route('tenants.index');
    }
}

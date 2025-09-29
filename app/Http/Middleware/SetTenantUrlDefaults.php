<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetTenantUrlDefaults
{
    public function handle($request, Closure $next)
    {
        if ($t = $request->route('tenant')) {
            URL::defaults(['tenant' => $t]);
        }
        return $next($request);
    }
}

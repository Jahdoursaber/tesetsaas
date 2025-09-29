<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant extends BaseTenant
{
    /**
     * Relation avec les domaines du tenant
     */
    public function domains()
    {
        return $this->hasMany(Domain::class, 'tenant_id');
    }
}

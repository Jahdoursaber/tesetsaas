<?php

namespace App\Models\Tenant;

use App\Models\User as BaseUser;

class User extends BaseUser
{
    // Inherits tenant-aware behaviour (BelongsToTenant, casts, fillable, ...)
}

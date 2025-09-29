<?php

declare(strict_types=1);

use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant;

return [
    'tenant_model' => Tenant::class,
    'domain_model' => Domain::class,

    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),
        'template_tenant_connection' => null,
        'prefix' => 'tenant',
        'suffix' => '',
        'separate_by' => 'prefix', // Use 'prefix' for single database tenancy
    ],

    'cache' => [
        'tag_base' => 'tenant',
    ],

    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
        ],
        'root_override' => [
            'local' => '%storage_path%/app/',
            'public' => '%storage_path%/app/public/',
        ],
    ],

    'routes' => [
        'path' => base_path('routes/tenant.php'),
        'middleware' => [
            'web',
            //'universal',
            'tenancy',
        ],
    ],

    'id_generator' => Stancl\Tenancy\UUIDGenerator::class,

    'middleware' => [
        'universal' => [
           // Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
        ],
        'tenant' => [
            Stancl\Tenancy\Middleware\InitializeTenancyByPath::class,
           // Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
        ],
        'central' => [
          //  Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
        ],
    ],

    'bootstrappers' => [
        //Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
        // Stancl\Tenancy\Bootstrappers\QueueTenancyBootstrapper::class,
        // Stancl\Tenancy\Bootstrappers\RedisTenancyBootstrapper::class,
    ],

    'features' => [
        // Stancl\Tenancy\Features\UserImpersonation::class,
        // Stancl\Tenancy\Features\TelescopeTags::class,
        // Stancl\Tenancy\Features\UniversalRoutes::class,
        Stancl\Tenancy\Features\TenantConfig::class,
       // Stancl\Tenancy\Features\CrossDomainRedirect::class,
    ],

    'central_domains' => [
        'app.test',
        'www.app.test',
    ],
];

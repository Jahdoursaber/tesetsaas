<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\DatabaseManager;

class DeleteDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TenantWithDatabase
     */
    protected $tenant;

    /**
     * Create a new job instance.
     *
     * @param TenantWithDatabase $tenant
     * @return void
     */
    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     *
     * @param DatabaseManager $databaseManager
     * @return void
     */
    public function handle(DatabaseManager $databaseManager): void
    {
        // Supprime la base de données du tenant
        $this->tenant->database()->delete();
    }
}

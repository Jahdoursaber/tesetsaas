<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'tenant_id')) {
                $table->string('tenant_id')->nullable()->after('id');
                $table->index('tenant_id');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            // Ensure composite uniqueness per tenant
            if (Schema::hasColumn('users', 'email')) {
                $table->dropUnique('users_email_unique');
                $table->unique(['email', 'tenant_id']);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'email') && Schema::hasColumn('users', 'tenant_id')) {
                $table->dropUnique('users_email_tenant_id_unique');
                $table->unique('email');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tenant_id')) {
                $table->dropIndex('users_tenant_id_index');
                $table->dropColumn('tenant_id');
            }
        });
    }
};
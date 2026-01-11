<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('lead_statuses') && ! Schema::hasColumn('lead_statuses', 'is_active')) {
            Schema::table('lead_statuses', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('name');
            });
        }

        if (Schema::hasTable('lead_sources') && ! Schema::hasColumn('lead_sources', 'is_active')) {
            Schema::table('lead_sources', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('name');
            });
        }

        if (Schema::hasTable('action_types') && ! Schema::hasColumn('action_types', 'is_active')) {
            Schema::table('action_types', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('lead_statuses') && Schema::hasColumn('lead_statuses', 'is_active')) {
            Schema::table('lead_statuses', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('lead_sources') && Schema::hasColumn('lead_sources', 'is_active')) {
            Schema::table('lead_sources', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        if (Schema::hasTable('action_types') && Schema::hasColumn('action_types', 'is_active')) {
            Schema::table('action_types', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};

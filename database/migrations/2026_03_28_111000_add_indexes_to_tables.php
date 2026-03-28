<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add indexes for better query performance
     */
    public function up(): void
    {
        // Indexes on devices table
        Schema::table('devices', function (Blueprint $table) {
            $table->index('asset_code');
            $table->index('status');
            $table->index('location');
        });

        // Indexes on spareparts table
        Schema::table('spareparts', function (Blueprint $table) {
            $table->index('part_code');
            $table->index('part_category');
        });

        // Indexes on transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('part_id');
            $table->index('device_id');
            $table->index('transaction_date');
        });

        // Indexes on maintenance_logs table
        Schema::table('maintenance_logs', function (Blueprint $table) {
            $table->index('device_id');
            $table->index('maintenance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from devices table
        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex(['asset_code']);
            $table->dropIndex(['status']);
            $table->dropIndex(['location']);
        });

        // Drop indexes from spareparts table
        Schema::table('spareparts', function (Blueprint $table) {
            $table->dropIndex(['part_code']);
            $table->dropIndex(['part_category']);
        });

        // Drop indexes from transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['part_id']);
            $table->dropIndex(['device_id']);
            $table->dropIndex(['transaction_date']);
        });

        // Drop indexes from maintenance_logs table
        Schema::table('maintenance_logs', function (Blueprint $table) {
            $table->dropIndex(['device_id']);
            $table->dropIndex(['maintenance_date']);
        });
    }
};

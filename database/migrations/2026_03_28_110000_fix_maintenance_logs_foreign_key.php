<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maintenance_logs', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['device_id']);
            
            // Re-add with RESTRICT instead of CASCADE
            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_logs', function (Blueprint $table) {
            // Drop the new foreign key
            $table->dropForeign(['device_id']);
            
            // Restore to original CASCADE behavior
            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade');
        });
    }
};

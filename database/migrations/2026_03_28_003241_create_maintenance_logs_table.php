<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->integer('device_id');
            $table->date('maintenance_date');
            $table->enum('maintenance_type', ['preventive', 'corrective', 'upgrade']);
            $table->text('description');
            $table->integer('sparepart_id')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->string('technician', 100);
            $table->date('next_maintenance')->nullable();
            $table->dateTime('created_at');

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->foreign('sparepart_id')->references('id')->on('spareparts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};

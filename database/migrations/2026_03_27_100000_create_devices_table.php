<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // INT (PK, AI)
            $table->string('asset_code', 30)->unique();
            $table->enum('device_type', ['pc', 'laptop', 'server']);
            $table->string('brand', 50);
            $table->string('model', 100);
            $table->string('serial_number', 100)->unique();
            $table->string('processor', 100)->nullable();
            $table->integer('ram_size')->nullable()->comment('GB');
            $table->integer('storage_size')->nullable()->comment('GB');
            $table->enum('storage_type', ['ssd', 'hdd', 'nvme'])->nullable();
            $table->string('os', 50)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_until')->nullable();
            $table->enum('status', ['active', 'maintenance', 'retired', 'in_use'])->default('active');
            $table->string('location', 100)->nullable();
            $table->string('assigned_to', 100)->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();                         // deleted_at untuk soft delete
            $table->dateTime('created_at')->nullable();    // DATETIME sesuai spesifikasi
            $table->dateTime('updated_at')->nullable();    // DATETIME sesuai spesifikasi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};

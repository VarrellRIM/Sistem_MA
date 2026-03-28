<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spareparts', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary(); // INT (PK, AI)
            $table->string('part_code', 30)->unique();
            $table->enum('part_category', ['ram', 'ssd', 'hdd', 'psu', 'motherboard', 'keyboard', 'mouse', 'cable', 'other']);
            $table->string('part_name', 100);
            $table->string('brand', 50)->nullable();
            $table->string('specification', 200)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->string('supplier', 100)->nullable();
            $table->string('location', 50)->nullable();
            $table->dateTime('created_at')->nullable();    // DATETIME sesuai spesifikasi
            $table->dateTime('updated_at')->nullable();    // DATETIME sesuai spesifikasi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};

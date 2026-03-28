<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->string('transaction_code', 30)->unique();
            $table->integer('part_id');
            $table->integer('device_id')->nullable();
            $table->enum('transaction_type', ['in', 'out']);
            $table->integer('quantity');
            $table->string('purpose', 200)->nullable();
            $table->string('requester', 100)->nullable();
            $table->string('technician', 100)->nullable();
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->dateTime('created_at');

            $table->foreign('part_id')->references('id')->on('spareparts')->onDelete('restrict');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->string('rfid')->nullable();
            $table->string('name');
            $table->text('description');
            $table->enum('status', ['stock', 'borrowed','unavailable','missing'])->default('stock');
            $table->foreignId('category');
            $table->string('image');
            $table->foreignId('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};

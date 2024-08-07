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
            $table->string('barcode')->nullable()->unique();
            $table->string('rfid')->nullable()->unique();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            //$table->enum('status', ['stock', 'borrowed','unavailable','missing'])->default('stock');
            $table->foreignId('category_id')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->boolean('status')->default(0);
            $table->text('borrow_purpose')->nullable();
            $table->dateTime('borrow_date_start')->nullable();
            $table->dateTime('borrow_date_return_deadline')->nullable();
            $table->dateTime('borrow_last_returned')->nullable();
            $table->integer('borrowed_count')->nullable()->default(0);
            $table->string('noted_instructor')->nullable();
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

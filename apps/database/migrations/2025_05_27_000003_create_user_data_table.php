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
        Schema::create('user_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();;
            $table->string('phone', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('nik')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->string('bank')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
        });
    }

    // $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_data');
    }
};

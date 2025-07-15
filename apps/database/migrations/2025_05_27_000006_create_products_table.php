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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('restrict');
            // $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();;
            $table->string('product_name', 40);
            $table->string('description', 200);
            $table->integer('quantity');
            $table->enum('units', ['kg', 'ton', 'ons', 'kuintal']);
            $table->enum('status', ['available', 'use', 'sold']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

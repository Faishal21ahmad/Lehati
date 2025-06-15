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
            $table->foreignId('auctioneer_id')->constrained('auctioneer_data');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('product_name', 40);
            $table->string('description', 200);
            $table->integer('quantity');
            $table->enum('unit', ['kg', 'ton', 'ons', 'ikat']);
            $table->enum('status', ['available', 'sold']);
            $table->timestamps();

            $table->index('auctioneer_id');
            $table->index('category_id');
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

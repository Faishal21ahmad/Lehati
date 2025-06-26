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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_code', 8)->unique();
            $table->string('title_room', 30);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->string('description', 200);
            $table->enum('status', ['upcoming', 'ongoing', 'ended', 'cancelled']);
            $table->decimal('starting_price', 15, 2);
            $table->decimal('min_bid_step', 15, 2);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();

            $table->index('user_id');
            $table->index('room_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participan_id')->references('id')->on('participants')->restrictOnDelete();;
            $table->foreignId('room_id')->references('id')->on('rooms')->restrictOnDelete();;
            $table->decimal('amount', 15, 0);
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('room_id');
            $table->index('participan_id');
            $table->index('is_winner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};

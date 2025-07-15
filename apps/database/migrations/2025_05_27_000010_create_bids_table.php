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
            // $table->unsignedBigInteger('participan_id')->constrained('participants')->onDelete('restrict');
            // $table->unsignedBigInteger('room_id')->constrained('rooms')->onDelete('restrict');
            // $table->foreignId('participan_id')->constrained()->onDelete('restrict');
            // $table->foreignId('room_id')->constrained()->onDelete('restrict');
            $table->foreignId('participan_id')->references('id')->on('participants')->restrictOnDelete();;
            $table->foreignId('room_id')->references('id')->on('rooms')->restrictOnDelete();;
            $table->decimal('amount', 15, 2);
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

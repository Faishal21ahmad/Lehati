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
        Schema::create('auctioneer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auctioneer_id')->constrained('auctioneer_data');
            $table->foreignId('action_by')->constrained('users');
            $table->enum('status', ['processing', 'approved', 'rejected', 'revoked']);
            $table->text('notes')->nullable();
            $table->dateTime('reviewed_at');
            $table->timestamps();

            $table->index('auctioneer_id');
            $table->index('action_by');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctioneer_logs');
    }
};

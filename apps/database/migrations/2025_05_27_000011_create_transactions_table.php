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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code_transaksi', 13)->unique();
            $table->foreignId('bid_id')->constrained('bids');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['unpaid', 'payment-verification', 'failed', 'success']);
            $table->string('payment_proof', 100)->nullable();
            $table->text('notes')->nullable();
            $table->decimal('amount_final', 15, 2);
            $table->timestamp('payment_verified_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('bid_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

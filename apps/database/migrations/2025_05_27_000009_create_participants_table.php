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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete();;
            $table->foreignId('room_id')->references('id')->on('rooms')->restrictOnDelete();;
            $table->enum('status', ['joined', 'rejected', 'leave'])->default('joined');
            $table->timestamps();
            $table->softDeletes();

            $table->index('room_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

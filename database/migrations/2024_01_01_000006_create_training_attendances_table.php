<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->boolean('attended')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Ensure a player can only have one attendance record per training
            $table->unique(['training_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_attendances');
    }
};

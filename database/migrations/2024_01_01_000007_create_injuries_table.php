<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('injuries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., "Ankle sprain", "Hamstring"
            $table->text('description')->nullable();
            $table->date('injury_date');
            $table->date('expected_recovery_date')->nullable();
            $table->date('actual_recovery_date')->nullable();
            $table->enum('status', ['active', 'recovering', 'recovered'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('injuries');
    }
};

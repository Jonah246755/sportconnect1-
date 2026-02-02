<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Ajax A1", "Under 15 Boys"
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->string('age_group')->nullable(); // e.g., "U15", "Senior"
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};

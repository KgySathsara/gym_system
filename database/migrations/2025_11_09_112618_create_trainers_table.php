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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization');
            $table->integer('experience_years');
            $table->text('certifications')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('hourly_rate', 8, 2);
            $table->boolean('is_available')->default(true);
            $table->json('working_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};

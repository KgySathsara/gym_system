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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->nullable()->constrained('trainers')->onDelete('set null');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->date('join_date');
            $table->date('expiry_date');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('fitness_goals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

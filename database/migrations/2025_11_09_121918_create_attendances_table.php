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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out')->nullable();
            $table->integer('workout_duration')->nullable();
            $table->string('workout_type')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['member_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

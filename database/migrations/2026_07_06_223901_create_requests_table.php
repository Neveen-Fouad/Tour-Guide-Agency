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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Tourist_id')->constrained()->onDelete('cascade');
            $table->foreignId('Tour_Guide_id')->constrained()->onDelete('cascade');
            $table->boolean('is_approved')->default(false);
            $table->string('destination');
            $table->string('status')->default('pending'); 
            $table->string('preferred_language')->nullable();
            $table->text('plan')->nullable();
            $table->dateTime('arrival_time');
            $table->dateTime('departure_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->time('from_after_break')->nullable();
            $table->time('to_after_break')->nullable();
            $table->string('live_link')->nullable();
            $table->string('link')->nullable();
            $table->foreignId('track_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};

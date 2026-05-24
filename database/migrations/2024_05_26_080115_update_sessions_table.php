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
        Schema::table('sessions', function (Blueprint $table) {
            // Remove columns
            $table->dropColumn('from_after_break');
            $table->dropColumn('to_after_break');
            $table->dropColumn('title');

            // Make track_id nullable
            $table->unsignedBigInteger('track_id')->nullable()->change();

            // Add new columns
            $table->boolean('is_active')->default(false);
            $table->string('speaker')->nullable();
            $table->string('speaker_job_title')->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            $table->time('from_after_break')->nullable();
            $table->time('to_after_break')->nullable();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('track_id')->nullable(false)->change();
            $table->dropColumn('is_active');
            $table->dropColumn('speaker');
            $table->dropColumn('speaker_job_title');
        });
    }
};

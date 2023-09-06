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
        Schema::create('journey_pattern_stop_usages', function (Blueprint $table) {
            $table->id();
            $table->string('sequence_number');
            $table->string('activity');
            $table->string('dynamic_destination_display');
            $table->string('stop_point_ref');
            $table->string('timing_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journey_pattern_stop_usages');
    }
};

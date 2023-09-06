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
        Schema::create('journey_pattern_timing_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journey_pattern_section_id');
            $table->bigInteger('from_id')->unsigned();
            $table->bigInteger('to_id')->unsigned();
            $table->foreign('from_id', '36544_5cf21247154fd')->references('id')->on('journey_pattern_stop_usages');
            $table->foreign('to_id', '36544_5cf212471565s')->references('id')->on('journey_pattern_stop_usages');
            $table->string('route_link_ref');
            $table->string('run_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journey_pattern_timing_links');
    }
};

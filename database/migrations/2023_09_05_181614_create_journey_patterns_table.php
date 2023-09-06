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
        Schema::create('journey_patterns', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('destination_display');
            $table->string('direction');
            $table->string('route_ref');
            $table->string('journey_pattern_section_refs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journey_patterns');
    }
};

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
        Schema::create('stop_points', function (Blueprint $table) {
            $table->id();
            $table->string('common_name');
            $table->string('atco_code');
            $table->string('locality_reference');
            $table->string('stop_type');
            $table->string('timing_status')->nullable();
            $table->string('administrative_area_ref')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('schedule_id');
            $table->foreignId('location_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stop_points');
    }
};

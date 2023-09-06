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
        Schema::create('vehicle_journeys', function (Blueprint $table) {
            $table->id();
            $table->string('private_code');
            $table->string('operating_period');
            $table->string('bank_holiday_days_of_operation');
            $table->string('bank_holiday_days_of_non_operation');
            $table->string('garage_ref');
            $table->string('vehicle_journey_code');
            $table->string('service_ref');
            $table->string('line_ref');
            $table->string('journey_pattern_ref');
            $table->string('departure_time');
            $table->foreignId('layover_point_id')->nullable();
            $table->foreignId('ticket_machine_id')->nullable();
            $table->foreignId('schedule_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_journeys');
    }
};

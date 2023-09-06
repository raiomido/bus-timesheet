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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code');
            $table->string('private_code');
            $table->string('start_date');
            $table->string('end_date');
//            $table->string('end_date');
            $table->string('operating_period');
            $table->string('bank_holiday_days_of_operation');
            $table->string('bank_holiday_days_of_non_operation');
            $table->string('registered_operator_ref');
            $table->string('mode');
            $table->string('standard_service_origin');
            $table->string('standard_service_destination');
            $table->foreignId('schedule_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

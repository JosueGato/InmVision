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
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('client_id')->index('fk_appointments_clients1_idx');
            $table->unsignedInteger('propertyprice_id')->index('fk_appointments_propertyprices1_idx');
            $table->date('creation_date')->nullable();
            $table->text('comment')->nullable();
            $table->integer('reprogramation_number')->nullable()->default(0);
            $table->unsignedInteger('appointmentstate_id')->nullable()->index('fk_appointments_appointmentstates1_idx');
            $table->unsignedInteger('schedule_id')->nullable()->index('fk_appointments_schedules1_idx');
            $table->unsignedTinyInteger('is_active')->nullable()->default(0);
            $table->date('appointment_date')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};

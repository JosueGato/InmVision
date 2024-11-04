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
        Schema::create('reprogramedappointments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appointment_id')->nullable()->index('fk_reprogramedappointments_appointments1_idx');
            $table->unsignedInteger('schedule_id')->nullable()->index('fk_reprogramedappointments_schedules1_idx');
            $table->date('original_date')->nullable();
            $table->date('actual_date')->nullable();
            $table->text('reason')->nullable();
            $table->date('new_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reprogramedappointments');
    }
};

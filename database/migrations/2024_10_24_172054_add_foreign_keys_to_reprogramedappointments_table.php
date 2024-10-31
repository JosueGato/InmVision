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
        Schema::table('reprogramedappointments', function (Blueprint $table) {
            $table->foreign(['appointment_id'], 'fk_reprogramedappointments_appointments1')->references(['id'])->on('appointments')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['schedule_id'], 'fk_reprogramedappointments_schedules1')->references(['id'])->on('schedules')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reprogramedappointments', function (Blueprint $table) {
            $table->dropForeign('fk_reprogramedappointments_appointments1');
            $table->dropForeign('fk_reprogramedappointments_schedules1');
        });
    }
};

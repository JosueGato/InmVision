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
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign(['appointmentstate_id'], 'fk_appointments_appointmentstates1')->references(['id'])->on('appointmentstates')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['client_id'], 'fk_appointments_clients1')->references(['id'])->on('clients')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['propertyprice_id'], 'fk_appointments_propertyprices1')->references(['id'])->on('propertyprices')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['schedule_id'], 'fk_appointments_schedules1')->references(['id'])->on('schedules')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('fk_appointments_appointmentstates1');
            $table->dropForeign('fk_appointments_clients1');
            $table->dropForeign('fk_appointments_propertyprices1');
            $table->dropForeign('fk_appointments_schedules1');
        });
    }
};

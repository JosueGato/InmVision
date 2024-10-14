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
        Schema::create('cancelledappointments', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('appointment_id')->nullable()->index('fk_cancelledappointments_appointments1_idx');
            $table->date('cancelation_date')->nullable();
            $table->text('other')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelledappointments');
    }
};

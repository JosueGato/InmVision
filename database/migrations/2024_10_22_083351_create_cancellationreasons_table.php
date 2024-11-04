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
        Schema::create('cancellationreasons', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('cancelledappointment_id')->nullable()->index('fk_cancellationreasons_cancelledappointments1_idx');
            $table->unsignedInteger('cancellation_id')->nullable()->index('fk_cancellationreasons_cancellations1_idx');

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancellationreasons');
    }
};

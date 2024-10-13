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
        Schema::table('cancellationreasons', function (Blueprint $table) {
            $table->foreign(['cancellation_id'], 'fk_cancellationreasons_cancellations1')->references(['id'])->on('cancellations')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['cancelledappointment_id'], 'fk_cancellationreasons_cancelledappointments1')->references(['id'])->on('cancelledappointments')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cancellationreasons', function (Blueprint $table) {
            $table->dropForeign('fk_cancellationreasons_cancellations1');
            $table->dropForeign('fk_cancellationreasons_cancelledappointments1');
        });
    }
};

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->time('hour');
            $table->unsignedInteger('scheduletype_id')->nullable()->index('fk_schedules_scheduletypes1_idx');
            $table->string('schedule_name', 50)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

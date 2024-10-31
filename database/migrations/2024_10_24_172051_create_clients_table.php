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
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->string('ci', 9);
            $table->string('client_name', 90);
            $table->string('client_last_name', 90);
            $table->string('client_cellphone_number', 8);
            $table->string('client_email', 100);
            $table->string('pass', 45);
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

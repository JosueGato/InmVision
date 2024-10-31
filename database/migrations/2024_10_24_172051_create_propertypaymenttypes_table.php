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
        Schema::create('propertypaymenttypes', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('paymenttype_id')->index('fk_propertypaymenttypes_paymenttypes1_idx');
            $table->unsignedInteger('property_id')->index('fk_propertypaymenttypes_properties1_idx');
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propertypaymenttypes');
    }
};

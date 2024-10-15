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
        Schema::create('propertyservices', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('service_id')->index('fk_propertyservices_services1_idx');
            $table->unsignedInteger('property_id')->index('fk_propertyservices_properties1_idx');
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propertyservices');
    }
};

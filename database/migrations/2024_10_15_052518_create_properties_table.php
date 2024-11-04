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
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('propertystate_id')->index('fk_properties_propertystates1_idx');
            $table->string('property_code', 40)->nullable();
            $table->string('direction', 90);
            $table->decimal('total_land_area', 10);
            $table->integer('bedroom_number');
            $table->string('bathroom_numbers', 2);
            $table->string('construction_year', 4);
            $table->string('description', 230)->nullable();
            $table->string('constructed_area', 6)->nullable();
            $table->text('property_image')->nullable();
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

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
        Schema::create('propertyprices', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedBigInteger('user_id');
            $table->string('propertyprice_code', 40)->nullable();
            $table->decimal('price_bs', 10)->nullable();
            $table->decimal('price_us', 10)->nullable();
            $table->date('registration_date')->nullable();
            $table->unsignedInteger('property_id')->index('fk_propertyprices_properties1_idx');
            $table->unsignedInteger('propertylisting_id')->index('fk_propertyprices_propertylistings1_idx');
            $table->tinyInteger('is_active')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propertyprices');
    }
};

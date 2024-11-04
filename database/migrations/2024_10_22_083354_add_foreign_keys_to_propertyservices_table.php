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
        Schema::table('propertyservices', function (Blueprint $table) {
            $table->foreign(['property_id'], 'fk_propertyservices_properties1')->references(['id'])->on('properties')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['service_id'], 'fk_propertyservices_services1')->references(['id'])->on('services')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propertyservices', function (Blueprint $table) {
            $table->dropForeign('fk_propertyservices_properties1');
            $table->dropForeign('fk_propertyservices_services1');
        });
    }
};

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
        Schema::table('propertyowners', function (Blueprint $table) {
            $table->foreign(['owner_id'], 'fk_propertyowners_owners1')->references(['id'])->on('owners')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['property_id'], 'fk_propertyowners_properties1')->references(['id'])->on('properties')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propertyowners', function (Blueprint $table) {
            $table->dropForeign('fk_propertyowners_owners1');
            $table->dropForeign('fk_propertyowners_properties1');
        });
    }
};

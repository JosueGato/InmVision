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
        Schema::table('propertyprices', function (Blueprint $table) {
            $table->foreign(['property_id'], 'fk_propertyprices_properties1')->references(['id'])->on('properties')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['propertylisting_id'], 'fk_propertyprices_propertylistings1')->references(['id'])->on('propertylistings')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'fk_propertyprices_users1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propertyprices', function (Blueprint $table) {
            $table->dropForeign('fk_propertyprices_properties1');
            $table->dropForeign('fk_propertyprices_propertylistings1');
            $table->dropForeign('fk_propertyprices_users1');
        });
    }
};

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
        Schema::table('propertypaymenttypes', function (Blueprint $table) {
            $table->foreign(['paymenttype_id'], 'fk_propertypaymenttypes_paymenttypes1')->references(['id'])->on('paymenttypes')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['property_id'], 'fk_propertypaymenttypes_properties1')->references(['id'])->on('properties')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propertypaymenttypes', function (Blueprint $table) {
            $table->dropForeign('fk_propertypaymenttypes_paymenttypes1');
            $table->dropForeign('fk_propertypaymenttypes_properties1');
        });
    }
};

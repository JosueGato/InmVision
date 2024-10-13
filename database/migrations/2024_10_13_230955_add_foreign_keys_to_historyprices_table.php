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
        Schema::table('historyprices', function (Blueprint $table) {
            $table->foreign(['propertyprice_id'], 'fk_historyprices_propertyprices1')->references(['id'])->on('propertyprices')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historyprices', function (Blueprint $table) {
            $table->dropForeign('fk_historyprices_propertyprices1');
        });
    }
};
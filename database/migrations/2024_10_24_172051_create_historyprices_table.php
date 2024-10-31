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
        Schema::create('historyprices', function (Blueprint $table) {
            $table->increments('id')->unique('id_unique');
            $table->unsignedInteger('propertyprice_id')->nullable()->index('fk_historyprices_propertyprices1_idx');
            $table->date('change_date')->nullable();
            $table->decimal('actual_price_bs', 10)->nullable();
            $table->decimal('actual_price_us', 10)->nullable();
            $table->decimal('last_price_bs', 10)->nullable();
            $table->decimal('last_price_us', 10)->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historyprices');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->json('images')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('product_characteristics')->nullable();
            $table->longtext('dimensions')->nullable();
            $table->foreignId('series_id')->nullable()->constrained('product_series')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('other_attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

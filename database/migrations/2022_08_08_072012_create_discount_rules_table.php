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
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('min_price')->nullable();
            $table->integer('min_item')->defult(0);
            $table->integer('discount_item_count')->nullable();
            $table->integer('discount_item_type')->nullable();
            $table->integer('is_equal_products_on_category')->nullable();
            $table->integer('discount');
            $table->integer('discount_type');
            $table->integer('number_of_uses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rules');
    }
};

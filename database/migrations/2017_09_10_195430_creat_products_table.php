<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create products schema
        If (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id');
                $table->string('item_id')->unique();
                $table->integer('parent_item_id')->unsigned()->nullable();
                $table->string('upc')->nullable();
                $table->string('name')->nullable();
                $table->decimal('msrp')->nullable();
                $table->decimal('sale_price')->nullable();
                $table->string('category_path')->nullable();
                $table->string('brand_name')->nullable();
                $table->decimal('average_rating')->nullable();
                $table->integer('rating_value_1')->nullable()->unsigned();
                $table->integer('rating_value_2')->nullable()->unsigned();
                $table->integer('rating_value_3')->nullable()->unsigned();
                $table->integer('rating_value_4')->nullable()->unsigned();
                $table->integer('rating_value_5')->nullable()->unsigned();
                $table->integer('number_of_reviews')->nullable()->unsigned();
                $table->mediumText('short_description')->nullable();
                $table->string('thumbnail_image')->nullable();
                $table->string('medium_image')->nullable();
                $table->string('large_image')->nullable();
                $table->boolean('ninety_seven_cent_shipping')->nullable();
                $table->decimal('standard_ship_rate')->nullable();
                $table->smallInteger('two_three_day_shipping')->nullable();
                $table->decimal('overnight_shipping_rate')->nullable();
                $table->string('size')->nullable();
                $table->string('seller_info')->nullable();
                $table->boolean('ship_to_store')->nullable();
                $table->boolean('free_ship_to_store')->nullable();
                $table->string('color')->nullable();
                $table->decimal('customer_rating')->nullable();
                $table->string('customer_rating_image')->nullable();
                $table->boolean('marketplace')->nullable();
                $table->text('product_url')->nullable();
                $table->string('category_node')->nullable();
                $table->boolean('bundle')->nullable();
                $table->boolean('clearance')->nullable();
                $table->boolean('pre_order')->nullable();
                $table->string('stock')->nullable();
                $table->boolean('free_shipping_over_50_dollars')->nullable();
                $table->boolean('available_online')->nullable();
                $table->timestamps();


            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('products');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        If (!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('product_id')->unsigned();
                $table->string('thumbnail_image')->nullable();
                $table->string('medium_image')->nullable();
                $table->string('large_image')->nullable();
                $table->string('entity_type')->nullable();
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('images');
    }
}

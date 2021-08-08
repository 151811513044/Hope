<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id_product');
            $table->integer('category_id')->index('fk_kategori');
            $table->integer('store_id')->index('fk_store');
            $table->string('nama_product');
            $table->string('slug');
            $table->string('harga_product');
            $table->string('stock_product');
            $table->longText('description');
            $table->longText('long_description');
            $table->bigInteger('berat')->nullable();

            $table->softDeletes();
            $table->timestamps();
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
}

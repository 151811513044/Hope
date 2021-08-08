<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->integer('cust_id');
            $table->string('uuid');
            $table->string('name');
            $table->string('phone');
            $table->longText('alamat');
            $table->date('tanggal');
            $table->integer('total_transaksi');
            $table->string('status');
            $table->tinyInteger('is_cart');

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
        Schema::dropIfExists('transactions');
    }
}

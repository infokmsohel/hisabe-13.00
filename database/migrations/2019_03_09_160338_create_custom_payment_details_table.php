<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cp_id')->unsigned();
            $table->foreign('cp_id')->references('id')->on('custom_payments');
            $table->string('itemName');
            $table->string('quantity')->default(1);
            $table->float('unitPrice',10,2);
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
        Schema::dropIfExists('custom_payment_details');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id');
            $table->string('customerName');
            $table->string('customerAddress');
            $table->string('productName');
            $table->string('note')->nullable();            
            $table->float('amount',10,2);  
            $table->integer('paymentStatus');
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
        Schema::dropIfExists('advance_payments');
    }
}

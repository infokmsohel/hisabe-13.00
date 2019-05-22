<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_ledgers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('date')->nullable();
            $table->integer('description')->nullable();
            $table->integer('debit')->nullable();
            $table->integer('credit')->nullable();
            $table->integer('balance')->nullable();
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
        Schema::dropIfExists('customer_ledgers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomPaymentAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_payments', function (Blueprint $table) {
            $table->string('customPaymentMethod')->nullable()->after('paymentAmount');
            $table->text('customPaymentNote')->nullable()->after('customPaymentMethod');
            $table->string('customerName')->nullable()->after('customPaymentNote');
            $table->string('customerAddress')->nullable()->after('customerName');
            $table->string('phoneNo')->nullable()->after('customerAddress');
            $table->integer('paymentAccountId')->nullable()->after('phoneNo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('custom_payments', function (Blueprint $table) {
            $table->dropColumn('customPaymentMethod');
            $table->dropColumn('customPaymentNote');
            $table->dropColumn('customerName');
            $table->dropColumn('customerAddress');
            $table->dropColumn('phoneNo');
            $table->dropColumn('paymentAccountId');
         
        });
         
        
    }
}

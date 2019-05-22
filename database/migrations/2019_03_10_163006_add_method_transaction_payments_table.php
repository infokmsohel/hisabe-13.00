<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMethodTransactionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->enum('method', ['cash', 'card', 'cheque', 'bank_transfer', 'other','bkash','emi'])->after('amount');           
            $table->string('depositor_name')->nullable()->after('bank_account_number');
            $table->string('emi_no')->nullable()->after('depositor_name');
            $table->string('phone_number')->nullable()->after('emi_no');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

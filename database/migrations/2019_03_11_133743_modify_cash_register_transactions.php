<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyCashRegisterTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_register_transactions', function (Blueprint $table) {
            DB::statement("ALTER TABLE `cash_register_transactions` CHANGE `pay_method` `pay_method` ENUM('cash','card','cheque','bank_transfer','custom_pay_1','custom_pay_2','custom_pay_3','other','bkash','emi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL ");
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

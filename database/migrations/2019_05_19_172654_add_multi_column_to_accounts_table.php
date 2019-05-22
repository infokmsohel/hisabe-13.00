<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiColumnToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('account_category')->nullable()->before('created_at');
            $table->string('new_account_type')->nullable()->before('created_at');
            $table->string('bank_id')->nullable()->before('created_at');
            $table->string('new_account_number')->nullable()->before('created_at');
            $table->integer('division_id')->nullable()->before('created_at');
            $table->integer('district_id')->nullable()->before('created_at');
            $table->string('mobile_bank')->nullable()->before('created_at');
            $table->string('number')->nullable()->before('created_at');
            $table->string('card_name')->nullable()->before('created_at');
            $table->string('card_number')->nullable()->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('account_category');
            $table->dropColumn('new_account_type');
            $table->dropColumn('bank_id');
            $table->dropColumn('new_account_number');
            $table->dropColumn('division_id');
            $table->dropColumn('district_id');
            $table->dropColumn('mobile_bank');
            $table->dropColumn('number');
            $table->dropColumn('card_name');
            $table->dropColumn('card_number');
        });
    }
}

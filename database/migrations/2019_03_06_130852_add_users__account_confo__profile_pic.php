<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUsersAccountConfoProfilePic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('accountConfirmation')->default(0)->after('selected_contacts');
            $table->string('profilePic')->nullable()->after('selected_contacts');
        });
        $this->ActivePreviosUser();
    }
    
    public function ActivePreviosUser() {
        DB::table('users')
            ->update(['accountConfirmation' => 1]);
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

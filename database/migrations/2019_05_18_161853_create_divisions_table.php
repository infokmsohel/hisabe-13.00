<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('bn_name');
            $table->timestamps();
        });
        
        $this->InsertData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
    
    /*
     * Insert Data
     */
    public function InsertData() {
        DB::table('divisions')->insert([
            ['name'=>'Dhaka','bn_name'=>'ঢাকা','created_at'=> Carbon\Carbon::now()],
            ['name' =>'Rajshahi','bn_name'=>'রাজশাহী','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Khulna','bn_name'=>'খুলনা','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Chattogram','bn_name'=>'চট্টগ্রাম','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Barishal','bn_name'=>'বরিশাল','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Rangpur','bn_name'=>'রংপুর','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Sylhet','bn_name'=>'সিলেট','created_at'=> Carbon\Carbon::now()] , 
            ['name' =>'Mymensingh','bn_name'=>'ময়মনসিংহ','created_at'=> Carbon\Carbon::now()], 
        ]);
    }
    
}

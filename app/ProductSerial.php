<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductSerial extends Model
{
    public function addSerial($productId,$serialNo) {
        if(empty($serialNo)){
            return;
        }
        if($this->checkSerial($productId,$serialNo)){
            $data = new ProductSerial();
            $data->product_id = $productId;
            $data->serialNo = $serialNo;
            $data->save();
        }
    }
    
    public function addGenSerial($productId,$serialNo) {
        if(empty($serialNo)){
            return;
        }
        if($this->checkSerial($productId,$serialNo)){
            $data = new ProductSerial();
            $data->product_id = $productId;
            $data->serialNo = $serialNo;
            $data->save();
        }else{
            $data = new ProductSerial();
            $data->product_id = $productId;
            $data->serialNo = $serialNo.'-1';
            $data->save();
        }
    }
    
    public function checkSerial($productId,$serialNo) {
        $data = ProductSerial::where('product_id','=',$productId)
                ->where('serialNo',$serialNo)->first();
        if(empty($data->id)){
            return true;
        }else{
            return false;
        }
    }
    
    public function getProductName($serialNo) {
        $data = DB::table('product_serials')
                ->leftjoin('products','products.id','=','product_serials.product_id')
                ->where('product_serials.serialNo','like', '%'. $serialNo . '%')
                ->select('products.name')->first();
        if(!empty($data->name)){
            return $data->name;
        }
        return $serialNo;
    }
    
    public function addSell($serialNo) {
        DB::table('product_serials')
                ->where('serialNo','=',$serialNo)
                ->delete();
    }
}

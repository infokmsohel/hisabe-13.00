<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Transaction;
use App\AccountTransaction;

class LeadgerController extends Controller
{
    
    public function MigrateOldTransaction() {
        $allTransaction = Transaction::all();
        foreach($allTransaction as $transaction){
            DB::table('');
        }
    }
    
    
    //Get Account Id
    protected function GetAccountId($transactionId){
        $data = AccountTransaction::where('transaction_id',$transactionId)->first();
        return $data->account_id;
    }
    
    //Get Product Info
    protected function GetSellProduct($transactionId) {
        $data = DB::table('transactions')
                    ->leftjoin('transaction_sell_lines as TSL','TSL.transaction_id','=','transactions.id')
                    ->leftjoin('products','products.id','=','TSL.product_id')
                    ->select('products.name')
                    ->where('transactions.id','=',$transactionId);
        return $data;
    }
    
    //Get Payment Info
    protected function GetPaymentInfo($transactionId) {
        $data = DB::table('transactions')
                     ->leftjoin('transaction_payments as TP','TP.transaction_id','=','transactions.id')
                     ->where('transactions.id','=',$transactionId)
                     ->select('TP.amount')->get();
        return $data;
    }
}

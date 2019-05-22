<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\CustomPayment;
use App\CustomPaymentDetails;
use App\Business;
use App\ConvertNumberInWord;
use App\AccountTransaction;
use DB;
use Carbon;

class CustomPaymentController extends Controller
{
    use ConvertNumberInWord;
    //Add Custom Payment
    public function AddPayment(Request $request) {
        $total = 0; 
        DB::beginTransaction();
        try{
            for($i = 1; $i <= $request->count; $i++ ){            
                $totalPrice = 'totalPrice'.$i;
                $total += str_replace(',','',$request->$totalPrice);
            }
        
            $payment = new CustomPayment();
            $payment->business_id = request()->session()->get('user.business_id');
            $payment->paymentAmount = $total;
            $payment->customPaymentMethod = $request->customPaymentMethod;
            $payment->customPaymentNote = $request->customPaymentNote;
            $payment->customerName = $request->customerName;
            $payment->customerAddress = $request->customerAddress;
            $payment->phoneNo = $request->phoneNo;
            
            If(!empty($request->customPaymentAccount) || $request->$request->customPaymentAccount != null){
                $payment->paymentAccountId = $request->customPaymentAccount;
            }            
            $payment->save();
            If(!empty($request->customPaymentAccount) || $request->$request->customPaymentAccount != null){
                $transaction_data = [
                    'amount' => $total,
                    'account_id' => $request->customPaymentAccount,
                    'type' => 'credit',
                    'sub_type' => null,
                    'operation_date' => $payment->created_at,
                    'created_by' => $request->session()->get('user.id'),
                    'transaction_id' => null,
                    'transaction_payment_id' => null,
                    'customPaymentTransactionId' =>$payment->id,
                    'note' => !empty($request->customPaymentNote) ?$request->customPaymentNote : null,
                    'transfer_transaction_id' => null,
                ];
                AccountTransaction::create($transaction_data);
            }
            $this->AddCustomPaymentDetails($request,$payment->id);
            DB::commit();
            return $this->GeneratePDF($payment->id,$total,$payment);
           
            
        } catch (Exception $ex) {
            DB::rollback();
            $output = ['success' => 0,
                'msg' => 'Error, Try again Later'
            ];
            return back()->with('status',$output);
        }
        
    }
    
    // Add Custom Payment Details
    protected function AddCustomPaymentDetails($request,$cp_id) {
        for($i = 1; $i <= $request->count; $i++ ){
            $itemName = 'itemName'.$i;
            $itemQty = 'itemQty'.$i;
            $itemPrice = 'itemPrice'.$i;
            
            DB::table('custom_payment_details')->insert([
                'cp_id' => $cp_id, 'itemName' =>$request->$itemName,
                'unitPrice' => str_replace(',','',$request->$itemPrice),'quantity' =>$request->$itemQty,
                'created_at' => Carbon::now(),'updated_at' =>Carbon::now()
            ]);
        }
    }
    
    // Generate PDF
    protected function GeneratePDF($id,$total,$customerInfo) {
        $data = DB::table('custom_payment_details')
                ->join('custom_payments','custom_payments.id','=','custom_payment_details.cp_id')
                ->where('custom_payments.id','=',$id)->get();
        $business = DB::table('business_locations')
                ->join('business','business_locations.business_id','=','business.id')
                ->where('business_locations.business_id','=',request()->session()->get('user.business_id'))
                ->select('business.name as bname','business.logo','business_locations.*')->first();
        $word = $this->Convert($total);
        $pdf = PDF::loadView('pdf.customPaymentInvoice',[
                    'datas'=>$data,'total'=>$total,'business'=>$business,
                    'customerInfo' => $customerInfo,'invoiceNo' =>$id,'inWord' =>$word
                ]);
        return $pdf->download('Invoice.pdf');
    }
    
    public function ShowDetails() {
        $payments = CustomPayment::where('business_id',request()->session()->get('user.business_id'))
                ->orderBy('created_at','DESC')->paginate(1000);
        return view('report.customPayment',compact('payments'));
    }
    
    public function PrintInvoice($id) {
        $payments = CustomPayment::find($id);
        return $this->GeneratePDF($id, $payments->paymentAmount, $payments);
    }
}

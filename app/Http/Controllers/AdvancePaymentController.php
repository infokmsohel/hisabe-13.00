<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdvancePayment;
use Yajra\Datatables\Facades\Datatables;
use PDF;
use App\ConvertNumberInWord;
use DB;
use Redirect;

class AdvancePaymentController extends Controller
{
    use ConvertNumberInWord;
    //
    public function ShowAdvncePaymentPage() {                
        $payments = AdvancePayment::where('business_id',request()->session()->get('user.business_id'))
                ->orderBy('id','DESC')->get();       
        return view('advancePayment.advancePayment',['payments'=>$payments]);
    }
    
    public function view() {
        $payments = AdvancePayment::select(['id','customerName','customerAddress','productName','note','amount','paymentStatus'])->first();
        return Datatables::of($payments)
            ->addColumn('action', function ($payments) {
                return '<a href="#edit-'.$payments->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->make(true);
    }
    
    public function Store(Request $request) {
        if($request->id == 0){
            $data = new AdvancePayment();
        }else{
            $data =  AdvancePayment::find($request->id);
        }
        $data->business_id = request()->session()->get('user.business_id');
        $data->customerName = $request->customerName;
        $data->customerAddress = $request->customerAddress;
        $data->productName = $request->productName;
        $data->note = $request->note;
        $data->amount = $request->amount;
        $data->paymentStatus = $request->paymentStatus;
        $data->save();
        $output = ['success' => 1,
                'msg' => trans("Successfully")
            ];
        //Redirect::to($this->GenerateInvoice($data->id));
        return redirect('AdvancePayment')->with('status',$output);
    }
    
    public function EditPayment($id) {
        $data =  AdvancePayment::where('business_id',request()->session()->get('user.business_id'))
                ->where('id','=',$id)->first();
        $payments = AdvancePayment::where('business_id',request()->session()->get('user.business_id'))
                ->orderBy('id','DESC')->get();       
        return view('advancePayment.advancePayment',['payments'=>$payments,'data'=>$data]);
    }
    
    public function PrintInvoice($id) {
        return $this->GenerateInvoice($id);
    }
    
    protected function GenerateInvoice($id) {
        $business = DB::table('business_locations')
                ->join('business','business_locations.business_id','=','business.id')
                ->where('business_locations.business_id','=',request()->session()->get('user.business_id'))
                ->select('business.name as bname','business.logo','business_locations.*')->first();
        $data =  AdvancePayment::where('business_id',request()->session()->get('user.business_id'))
                ->where('id','=',$id)->first();
        $word = $this->Convert($data->amount);
        $pdf = PDF::loadView('pdf.advancePayment',[
                    'data'=>$data,'business'=>$business,
                    'invoiceNo' =>$id,'inWord' =>$word
                ]);
        return $pdf->download('Invoice.pdf');
    }
}

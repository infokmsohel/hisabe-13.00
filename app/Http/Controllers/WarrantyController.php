<?php

namespace App\Http\Controllers;
use App\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WarrantyController extends Controller
{

    public function index()
    {


        if (!auth()->user()->can('sell.view') && !auth()->user()->can('sell.create') && !auth()->user()->can('direct_sell.access')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = session()->get('user.business_id');

        if (  request()->ajax()) {

            $warranties = DB::table('warranties')
                ->join('products', 'warranties.product_id', '=', 'products.id')
                ->where('warranties.business_id',$business_id)
                ->select('warranties.*','products.name as pname')
                ->get();


            return DataTables::of($warranties)
                ->addColumn('warranty_id', function ($warranties) {
                    return $warranties->id;
                })
                ->addColumn('sale_date', function ($warranties) {

                    return $warranties->sale_date;
                })
                ->addColumn('serial_id', function ($warranties) {

                    return $warranties->serial_id;
                })
                ->addColumn('product_name', function ($warranties) {

                    return $warranties->pname;
                })
                ->addColumn('warranty_type', function ($warranties) {

                    return $warranties->warranty_type;
                })
                ->addColumn('warranty_period', function ($warranties) {

                    return $warranties->warranty_period;
                })
                ->addColumn(
                    'action', '<button data-href="{{action(\'WarrantyController@edit\',[$id])}}" data-container=".account_model" class="btn btn-xs btn-primary btn-modal"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>'

                )
                ->rawColumns(['sale_date', 'serial_id', 'product_name','warranty_type','warranty_period','action'])
                ->make(true);
        }
        return view('warranty.index');
    }



    public function edit($id)
    {
        if (!auth()->user()->can('sell.view') && !auth()->user()->can('sell.create') && !auth()->user()->can('direct_sell.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $warranty = Warranty::where('business_id', $business_id)
                ->find($id);

            return view('warranty.edit',compact('warranty'));

        }
    }




    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('sell.view') && !auth()->user()->can('sell.create') && !auth()->user()->can('direct_sell.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (  request()->ajax()) {
            try {
                $input = $request->only(['warranty_type','warranty_period']);

                $business_id = request()->session()->get('user.business_id');
                $warranty = Warranty::where('business_id', $business_id)
                    ->findOrFail($id);
                $warranty->warranty_type = $input['warranty_type'];
                $warranty->warranty_period = $input['warranty_period'];
                $warranty->save();

                $output = ['success' => true,
                    'msg' => __("lang_v1.warranty_updated_success")
                ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => false,
                    'msg' => __("messages.something_went_wrong")
                ];
            }

            return $output;
        }
    }
}

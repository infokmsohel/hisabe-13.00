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
                ->rawColumns(['sale_date', 'serial_id', 'product_name','warranty_type','warranty_period'])
                ->make(true);
        }
        return view('warranty.index');
    }
}

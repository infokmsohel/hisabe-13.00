<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Bank;

class BankListController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $banks =Bank::all();
        return view('superadmin::bank.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('superadmin::bank.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['bank_name']);
            $category = Bank::create($input);
            $output = ['success' => true,
                'data' => $category,
                'msg' => __("category.bank_success")
            ];

            session()->flash('status','Bank Added Successfully');

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }

        return redirect()->action('\Modules\Superadmin\Http\Controllers\BankListController@index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
//    public function show(Bank $bank)
//    {
//        return view('superadmin::show');
//    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $bank=Bank::find($id);
        return view('superadmin::bank.edit',compact('bank'));
    }

//    public function edit(Product $product)
//    {
//        return view('products.edit',compact('product'));
//    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

             $input = $request->only(['bank_name']);
                $bank = Bank::findOrFail($id);
                $bank->bank_name = $input['bank_name'];
                $bank->save();

        session()->flash('status','Bank updated successfully');


                return redirect()->action('\Modules\Superadmin\Http\Controllers\BankListController@index');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function show($id)
    {

        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $bank = Bank::findOrFail($id);
        $bank->delete();
        session()->flash('status','Bank deleted successfully');
        return redirect()->back();
    }


}

<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\BusinessType;
use Modules\Superadmin\Entities\SubType;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $btypes=BusinessType::all();

        $subTypes=SubType::all();

        return view('superadmin::businesstype.index',compact('btypes','subTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('superadmin::businesstype.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
//    public function store(Request $request)
//    {
//        $create = BusinessType::create($request->all());
//        return response()->json($create);
//
//
//    }

    public function store(Request $request)
    {

        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['business_type']);
            $category = BusinessType::create($input);
            $output = ['success' => true,
                'data' => $category,
                'msg' => __("category.bank_success")
            ];

            session()->flash('status','Business name Added Successfully');

        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }

        return redirect()->action('\Modules\Superadmin\Http\Controllers\BusinessTypeController@index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {

        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $bank = BusinessType::findOrFail($id);
        $bank->delete();
        session()->flash('status','Business type deleted Successfully');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $btype=BusinessType::findOrFail($id);
        return view('superadmin::businesstype.edit',compact('btype'));
    }

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

        $input = $request->only(['business_type']);
        $bank = BusinessType::findOrFail($id);
        $bank->business_type = $input['business_type'];
        $bank->save();
        session()->flash('status','Business Type added updated successfully');
        return redirect()->action('\Modules\Superadmin\Http\Controllers\BusinessTypeController@index');

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}

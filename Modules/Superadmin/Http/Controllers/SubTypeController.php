<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\BusinessType;
use Modules\Superadmin\Entities\SubType;

class SubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
//        $btypes=BusinessType::all();

        return view('superadmin::subtype.index',compact('btypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $btypes=BusinessType::all();

//        $btypes=BusinessType::pluck('business_type','id');

        return view('superadmin::subtype.create',compact('btypes'));
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
            $input = $request->only(['business_type_id','sub_type']);
            $category = SubType::create($input);
            $output = ['success' => true,
                'data' => $category,
                'msg' => __("category.bank_success")
            ];

            session()->flash('status','Sub Type Added Successfully');

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

        $bank = SubType::findOrFail($id);
        $bank->delete();
        session()->flash('status','Sub type deleted Successfully');
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

        $btypes=BusinessType::all();

        $subType=SubType::findOrFail($id);

        return view('superadmin::subtype.edit',compact('btypes','subType'));
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

        $input = $request->only(['sub_type','business_type_id']);
        $bank = SubType::findOrFail($id);
        $bank->sub_type = $input['sub_type'];
        $bank->business_type_id = $input['business_type_id'];
        $bank->save();
        session()->flash('status','Sub Type Updated Successfully');
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

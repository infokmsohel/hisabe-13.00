<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Superadmin\Entities\Package;

use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;

use App\System;

class PackagesController extends BaseController
{
    /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(BusinessUtil $businessUtil, ModuleUtil $moduleUtil)
    {
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $packages = Package::orderby('sort_order', 'asc')
                    ->paginate(20);

        //Get all module permissions and convert them into name => label
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');
        $permission_formatted = [];
        foreach ($permissions as $permission) {
            foreach ($permission as $details) {
                $permission_formatted[$details['name']] = $details['label'];
            }
        }

        return view('superadmin::packages.index')
            ->with(compact('packages', 'permission_formatted'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        $intervals = ['days' => 'Days', 'months' => 'Months', 'years' => 'Years'];
        $currency = System::getCurrency();
        $permissions = $this->moduleUtil->getModuleData('superadmin_package');

        return view('superadmin::packages.create')
            ->with(compact('intervals', 'currency', 'permissions'));
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

        try{
            $input = $request->only(['name', 'description', 'location_count', 'user_count', 'product_count', 'invoice_count', 'interval', 'interval_count', 'trial_days', 'price', 'sort_order', 'is_active', 'custom_permissions', 'is_private', 'is_one_time', 'enable_custom_link', 'custom_link', 
                'custom_link_text']);

            $currency = System::getCurrency();

            $input['price'] = $this->businessUtil->num_uf($input['price'], $currency);
            $input['is_active'] = empty($input['is_active']) ? 0 : 1;
            $input['created_by'] = $request->session()->get('user.id');

            $input['is_private'] = empty($input['is_private']) ? 0 : 1;
            $input['is_one_time'] = empty($input['is_one_time']) ? 0 : 1;
            $input['enable_custom_link'] = empty($input['enable_custom_link']) ? 0 : 1;

            $input['custom_link'] = empty($input['enable_custom_link']) ? '' : $input['custom_link'];
            $input['custom_link_text'] = empty($input['enable_custom_link']) ? '' : $input['custom_link_text'];

            $package = new Package;
            $package->fill($input);
            $package->save();

            $output = ['success' => 1, 'msg' => __('lang_v1.success')];

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __('messages.something_went_wrong')
                        );
        }

        return redirect()
            ->action('\Modules\Superadmin\Http\Controllers\PackagesController@index')
            ->with('status', $output);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('superadmin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $packages = Package::where( 'id', $id)
                            ->first();
        
        $intervals = ['days' => 'Days', 'months' => 'Months', 'years' => 'Years'];

        $permissions = $this->moduleUtil->getModuleData('superadmin_package', true);

        return view('superadmin::packages.edit')
               ->with(compact('packages', 'intervals', 'permissions'));
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

        try{
            $packages_details = $request->only(['name', 'id', 'description', 'location_count', 'user_count', 'product_count', 'invoice_count', 'interval', 'interval_count', 'trial_days', 'price', 'sort_order', 'is_active', 'custom_permissions', 'is_private', 'is_one_time', 'enable_custom_link', 'custom_link', 'custom_link_text']);
            
            $packages_details['is_active'] = empty($packages_details['is_active']) ? 0 : 1;
            $packages_details['custom_permissions'] = empty($packages_details['custom_permissions']) ? null : $packages_details['custom_permissions'];

            $packages_details['is_private'] = empty($packages_details['is_private']) ? 0 : 1;
            $packages_details['is_one_time'] = empty($packages_details['is_one_time']) ? 0 : 1;
            $packages_details['enable_custom_link'] = empty($packages_details['enable_custom_link']) ? 0 : 1;
            $packages_details['custom_link'] = empty($packages_details['enable_custom_link']) ? '' : $packages_details['custom_link'];
            $packages_details['custom_link_text'] = empty($packages_details['enable_custom_link']) ? '' : $packages_details['custom_link_text'];

            $package = Package::where('id', $id)
                            ->first();
            $package->fill($packages_details);
            $package->save();   

            $output = ['success' => 1, 'msg' => __('lang_v1.success')];

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __('messages.something_went_wrong')
                        );
        }

        return redirect()
            ->action('\Modules\Superadmin\Http\Controllers\PackagesController@index')
            ->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try{
            Package::where('id', $id)
                ->delete();
            
            $output = ['success' => 1, 'msg' => __('lang_v1.success')];

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __('messages.something_went_wrong')
                        );
        }

        return redirect()
            ->action('\Modules\Superadmin\Http\Controllers\PackagesController@index')
            ->with('status', $output);
    }
}

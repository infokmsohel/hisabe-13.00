@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.subscription'))

@section('content')
<!-- Main content -->
<section class="content">
    @include('superadmin::layouts.partials.currency')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('superadmin::lang.all_subscriptions')</h3>
        </div>

        <div class="box-body">
        	<div class="row">
                <div class ="col-xs-12">
                <!-- location table -->
                    <table class="table table-bordered table-hover table-responsive" 
                    id="all_subscriptions_table">
                        <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Start Date</th>
                            <th>Trial End Date</th>
                            <th>End Date</th>
                            <th>Price</th>
                            <th>Paid Via</th>
                            <th>Payment Transaction ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>@lang('messages.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')

<script type="text/javascript">
	$(document).ready( function(){
    	$('#all_subscriptions_table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{action("\Modules\Superadmin\Http\Controllers\SubscriptionController@allSubscriptions")}}',
			columns: [
			    {data: 'package_name', name: 'P.name'},
			    {data: 'start_date', name: 'start_date'},
			    {data: 'trial_end_date', name: 'trial_end_date'},
			    {data: 'end_date', name: 'end_date'},
			    {data: 'package_price', name: 'package_price'},
			    {data: 'paid_via', name: 'paid_via'},
			    {data: 'payment_transaction_id', name: 'payment_transaction_id'},
			    {data: 'status', name: 'status'},
			    {data: 'created_at', name: 'created_at'},
			    {data: 'created_by', name: 'created_by'},
			    {data: 'action', name: 'action', searchable: false, orderable: false},
			],
			"fnDrawCallback": function (oSettings) {
            	__currency_convert_recursively($('#all_subscriptions_table'), true);
        	}
	    });
	});
</script>
@endsection
@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.subscription'))

@section('content')
<!-- Main content -->
<section class="content">

	@include('superadmin::layouts.partials.currency')
	
	<div class="box">
        <div class="box-header">            
            <div class="col-sm-3">
                <h3 class="box-title">@lang('superadmin::lang.active_subscription')</h3>
            </div>            
        </div>

        <div class="box-body">
            <div class="row">
                @if(!empty($active))
                    <div class="col-md-4 col-sm-6">
                        <div class="package-box padding-20">
                            <div class="package-heading text-center">
                                {{$active->package_details['name']}}
                                <div class="box-tools pull-right">
                                    <span class="badge bg-green">
                                        @lang('superadmin::lang.running')
                                    </span><br>
                                    <span class="badge bg-info btn-renew">
                                        <a href="{{action('\Modules\Superadmin\Http\Controllers\SubscriptionController@pay',$active->package_id)}}"> @lang('lang_v1.renew') </a>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="package-body">
                                @lang('superadmin::lang.start_date') : {{@format_date($active->start_date)}} <br/>
                                @lang('superadmin::lang.end_date') : {{@format_date($active->end_date)}} <br/>
                                @lang('superadmin::lang.remaining', ['days' => \Carbon::today()->diffInDays($active->end_date)])
                            </div>
                        </div>
                    </div>                        
                    @else
                    <div class="col-sm-6 col-md-4">
                        <h3 class="text-danger">@lang('superadmin::lang.no_active_subscription')</h3>
                    </div>  
                    @if(isset($oldSubscription->id))
                    <div class="col-sm-6 col-md-4">
                        <div class="package-box padding-20">
                            <div class="package-heading text-center">
                                {{$oldSubscription->package_details['name']}}
                                <div class="box-tools pull-right">                                    
                                    <span class="badge bg-info btn-renew">
                                        <a href="{{action('\Modules\Superadmin\Http\Controllers\SubscriptionController@pay',$oldSubscription->package_id)}}"> Renew </a>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="package-body">
                                @lang('superadmin::lang.start_date') : {{@format_date($oldSubscription->start_date)}} <br/>
                                @lang('superadmin::lang.end_date') : {{@format_date($oldSubscription->end_date)}} <br/>
                                @lang('superadmin::lang.remaining', ['days' => \Carbon::today()->diffInDays($oldSubscription->end_date)])
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
                
                <hr/>

        	@if(!empty($nexts))
                    <div class="clearfix"></div>
                        <div class="row">                            
                            @foreach($nexts as $next)
        			
                                    <div class="col-md-4 col-sm-6">
                                        <div class="package-box padding-20">
                                            <div class="package-heading text-center">
                                                {{$next->package_details['name']}}
                                            </div>
                                            <br>
                                            <div class="package-body">
                                                @lang('superadmin::lang.start_date') : {{@format_date($next->start_date)}} <br/>
                                                @lang('superadmin::lang.end_date') : {{@format_date($next->end_date)}}
                                            </div>
                                        </div>
                                    </div>
		        	
                            @endforeach
                            </div>
        	@endif

        	@if(!empty($waiting))
        		<div class="clearfix"></div>
        		@foreach($waiting as $row)
        			<div class="col-md-4">
		        		<div class="box box-success">
							<div class="box-header with-border text-center">
								<h2 class="box-title">
									{{$row->package_details['name']}}
								</h2>
							</div>
							<div class="box-body text-center">
                                @if($row->paid_via == 'offline')
                                    @lang('superadmin::lang.waiting_approval')
                                @else
                                    @lang('superadmin::lang.waiting_approval_gateway')
                                @endif
							</div>
						</div>
					</div>
        		@endforeach
        	@endif

        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('superadmin::lang.packages')</h3>
        </div>
        <hr/>
        <div class="box-body">
            @include('superadmin::subscription.partials.packages')
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
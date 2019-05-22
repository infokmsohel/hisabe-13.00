<!--<link rel="stylesheet" href="{{asset('logpage/vendors/css/base/elisyam-1.5.css')}}"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{ asset('js/isotop.min.js') }}"></script>
<link rel="stylesheet" href="{{asset('css/customize.css')}}">
<div class="row">
    <div class="col-sm-4 col-md-3">
        Filter By: 
        <select id="filter-user" onchange="FilterUser()" style="height:35px;width: 60%;border-radius:5px;">
            <option value="all" selected>Show All</option>
            @foreach ($userlist as $package)
            <option value="{{$package->user_count}}" {{ isset($_GET['filter']) && $_GET['filter'] == $package->user_count && $_GET['filter'] != 'all'?'selected':'' }} >  {{$package->user_count == 0?'Unlimited':$package->user_count}} Users</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-9 col-sm-8">
        <div id="filters" class="button-group text-right">  <button class="btn btn-info is-checked" data-filter="*">@lang('lang_v1.show')</button>
          <button class="btn btn-info" data-filter=".year">@lang('lang_v1.yearly')</button>
          <button class="btn btn-info" data-filter=".half-year">@lang('lang_v1.half_yearly')</button>
          <button class="btn btn-info" data-filter=".month">@lang('lang_v1.monthly')</button>  
        </div>
    </div>
</div>

<div class="grid">
        
@foreach ($packages as $package)
    @if($package->is_private == 1 && isset(auth()->user()->username) && !auth()->user()->username == env('ADMINISTRATOR_USERNAMES') )
	@php
            continue;
	@endphp
    @endif
    
        
        <div class="col-sm-6 col-md-4 package-box element-item 
            @if($package->interval == 'days')
                @if($package->interval_count == 365 )
                year
                @elseif($package->interval_count== 180)
                half-year
                @else
                month
                @endif
            @endif
            @if($package->interval == 'months')
                @if($package->interval_count == 12 )
                year
                @elseif($package->interval_count== 6)
                half-year
                @else
                month
                @endif
            @endif
            @if($package->interval == 'years')                
                year                
            @endif
            ">
                <div class="package-heading text-center" style="margin-top:20px;">{{$package->name}}</div>
                    <div class="package-body">
                        <div class="box-body text-center">
                            <div class="package-info">
				<i class="fa fa-check text-success"></i>
				@if($package->location_count == 0)
                                    @lang('superadmin::lang.unlimited')
				@else
                                    {{$package->location_count}}
				@endif
				@lang('business.business_locations')
                                <br>

				<i class="fa fa-check text-success"></i>
				@if($package->user_count == 0)
                                    @lang('superadmin::lang.unlimited')
				@else
                                    {{$package->user_count}}
				@endif
				@lang('superadmin::lang.users')
				<br>

				<i class="fa fa-check text-success"></i>
				@if($package->product_count == 0)
                                    @lang('superadmin::lang.unlimited')
				@else
                                    {{$package->product_count}}
				@endif
				@lang('superadmin::lang.products')
				<br>

				<i class="fa fa-check text-success"></i>
				@if($package->invoice_count == 0)
                                    @lang('superadmin::lang.unlimited')
				@else
                                    {{$package->invoice_count}}
				@endif
				@lang('superadmin::lang.invoices')
				<br>

				@if(!empty($package->custom_permissions))
                                    @foreach($package->custom_permissions as $permission => $value)
					@isset($permission_formatted[$permission])
                                            <i class="fa fa-check text-success"></i>
                                            {{$permission_formatted[$permission]}}
                                        @endisset
                                    @endforeach
				@endif

				@if($package->trial_days != 0)
                                    <i class="fa fa-check text-success"></i>
                                    {{$package->trial_days}} @lang('superadmin::lang.trial_days')				
				@endif
                                
                                <h3 class="text-center" style="margin-top:50px;">
                                    @if($package->price != 0)
                                    <span class="display_currency package-price" data-currency_symbol="true">
                                        {{$package->price}}
                                    </span>
                                    <small>
					/ {{$package->interval_count}} {{ucfirst($package->interval)}}
                                    </small>
                                    @else
					@lang('superadmin::lang.free_for_duration', ['duration' => $package->interval_count . ' ' . ucfirst($package->interval)])
                                    @endif
				</h3>
                                {{$package->description}}
                            </div>
                        </div>
                        <div class="box-footer text-center">
                                        @if($package->enable_custom_link == 1)
                                                <a href="{{$package->custom_link}}" class="btn btn-block btn-success">{{$package->custom_link_text}}</a>
                                        @else
                                                @if(isset($action_type) && $action_type == 'register')
                                                        <a href="{{ route('business.getRegister') }}?package={{$package->id}}" 
                                                        class="btn btn-pay btn-success">
                                                        @if($package->price != 0)
                                                                @lang('superadmin::lang.register_subscribe')
                                                        @else
                                                                @lang('superadmin::lang.register_free')
                                                        @endif
                                                </a>
                                                @else
                                                <a href="{{action('\Modules\Superadmin\Http\Controllers\SubscriptionController@pay', [$package->id])}}" 
                                                        class="btn btn-pay btn-success">
                                                        @if($package->price != 0)
                                                                @lang('superadmin::lang.pay_and_subscribe')
                                                        @else
                                                                @lang('superadmin::lang.subscribe')
                                                        @endif
                                                </a>
                                                @endif
                                        @endif

                        </div>	
                    </div>
        </div>
    @if($loop->iteration%3 == 0)
    	<div class="clearfix"></div>
    @endif
@endforeach
</div>  

<style>
    .is-checked{
        background: #EE017C !important;
    }
    .element-item{
        float: left;
    }
</style>

<script type="text/javascript">
    var $grid = $('.grid').isotope({
      itemSelector: '.element-item',
      layoutMode: 'fitRows',
    });

    // filter functions
    var filterFns = {
      // show if number is greater than 50
      numberGreaterThan50: function() {
        var number = $(this).find('.number').text();
        return parseInt( number, 10 ) > 50;
      },
      // show if name ends with -ium
      ium: function() {
        var name = $(this).find('.name').text();
        return name.match( /ium$/ );
      }
    };

    // bind filter button click
    $('#filters').on( 'click', 'button', function() {
      var filterValue = $( this ).attr('data-filter');
      // use filterFn if matches value
      filterValue = filterFns[ filterValue ] || filterValue;
      $grid.isotope({ filter: filterValue });
    });

    // bind sort button click
    $('#sorts').on( 'click', 'button', function() {
      var sortByValue = $(this).attr('data-sort-by');
      $grid.isotope({ sortBy: sortByValue });
    });

    // change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {
      var $buttonGroup = $( buttonGroup );
      $buttonGroup.on( 'click', 'button', function() {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');
      });
    });
    
    function FilterUser(){
        var x = $('#filter-user').val();
        window.location.href="?filter="+x;
    }
    
    </script>
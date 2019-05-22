@inject('request', 'Illuminate\Http\Request')
<!-- Main Header -->
  <header class="main-header no-print">
    <a href="/home" class="logo">
      
      <span class="logo-lg">{{ Session::get('business.name') }}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      @if(Module::has('Superadmin'))
        @include('superadmin::layouts.partials.active_subscription')
      @endif
      <!-- Add Package info -->
        @if(isset($packageActiveInfo) && !empty($packageActiveInfo))        
        <span class="remain-day navbar-custom-menu pull-left">
            {{$packageActiveInfo->package_details['name']}} | 
            @lang('superadmin::lang.remaining', ['days' => \Carbon::today()->diffInDays($packageActiveInfo->end_date)]) | 
            <a href="{{action('\Modules\Superadmin\Http\Controllers\SubscriptionController@pay',$packageActiveInfo->package_id)}}"> @lang('lang_v1.renew') </a>
        </span>
        @endif
        <!-- End Package info -->

      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        

        <button id="btnCalculator" title="@lang('lang_v1.calculator')" type="button" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10 popover-default" data-toggle="popover" data-trigger="click" data-content='@include("layouts.partials.calculator")' data-html="true" data-placement="bottom">
            <strong><i class="fa fa-calculator fa-lg" aria-hidden="true"></i></strong>
        </button>
        
        @if($request->segment(1) == 'pos')
          <button type="button" id="register_details" title="{{ __('cash_register.register_details') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10 btn-modal" data-container=".register_details_modal" 
          data-href="{{ action('CashRegisterController@getRegisterDetails')}}">
            <strong><i class="fa fa-briefcase fa-lg" aria-hidden="true"></i></strong>
          </button>
          <button type="button" id="close_register" title="{{ __('cash_register.close_register') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-danger btn-flat pull-left m-8 hidden-xs btn-sm mt-10 btn-modal" data-container=".close_register_modal" 
          data-href="{{ action('CashRegisterController@getCloseRegister')}}">
            <strong><i class="fa fa-window-close fa-lg"></i></strong>
          </button>
        @endif

        @can('sell.create')
          <a href="{{action('SellPosController@create')}}" title="POS" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fa fa-th-large"></i> &nbsp; @lang('sale.pos_sale')</strong>
          </a>
        @endcan
        @can('profit_loss_report.view')
          <button type="button" id="view_todays_profit" title="{{ __('home.todays_profit') }}" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fa fa-money fa-lg"></i></strong>
          </button>
        @endcan

        <!-- Help Button -->
        @if(auth()->user()->hasRole('Admin#' . auth()->user()->business_id))
          <button type="button" id="start_tour" title="@lang('lang_v1.application_tour')" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left m-8 hidden-xs btn-sm mt-10">
            <strong><i class="fa fa-question-circle fa-lg" aria-hidden="true"></i></strong>
          </button>
        @endif

        <div class="m-8 pull-left mt-15 hidden-xs" style="color: #fff;"><strong>{{ @format_date('now') }}</strong></div>

        <!-- User Account Menu -->
        <ul class="nav navbar-nav">
            <li class="nav-item dropdown">
                <a id="notifications" rel="nofollow" data-target="#" href="{{url('notification-templates')}}" >
                        <i class="fa fa-bell animated infinite swing"></i><span class="badge-pulse"></span></a>                                
            </li>
          
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
{{--             <img src="{{ asset(Session::get('business.logo')) }}" alt="Logo" height="35" width="35" class="img-circle">--}}

              @if(session()->has('business.logo') && file_exists(Session::get('business.logo')))
                <img src="{{ asset(Session::get('business.logo')) }}" alt="Logo" height="35" width="35" class="img-circle">
              @else
                <img src="{{ asset('uploads/profile/avatar.png') }}" alt="Logo" class="img-circle img-thumbnail" style="width:35px ; height: 35px !important;"><br>
              @endif

            </a>
            <ul class="dropdown-menu">
                
              <!-- The user image in the menu -->
              <li class="user-header">

                @if(Auth::user()->profilePic == null)
                  <img src="{{ asset('uploads/profile/avatar.png') }}" alt="Logo" class="img-circle img-thumbnail" style="width:60px !important;"><br>
                @else
                  <img src="{{ asset(Auth::user()->profilePic) }}" alt="Logo" class="img-circle img-thumbnail" style="width:60px !important;"><br>
                @endif
                {{ Auth::User()->first_name }} {{ Auth::User()->last_name }}
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                  <a href="{{action('UserController@getProfile')}}" >@lang('lang_v1.profile')</a>
                  <a href="#"> @lang('lang_v1.message')</a>
              </li> 
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="text-center user-logout">
                  <a href="{{action('Auth\LoginController@logout')}}" class="btn-logout">@lang('lang_v1.sign_out')</a>
                </div>
              </li>
            </ul>
          </li>
      </div>
    </nav>
  </header>
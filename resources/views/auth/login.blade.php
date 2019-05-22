@extends('layouts.auth')
@section('title', __('lang_v1.login'))

@section('content')
<link rel="stylesheet" href="{{asset('logpage/vendors/css/base/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('logpage/vendors/css/base/elisyam-1.5.min.css')}}"> 
<link rel="stylesheet" href="{{asset('css/customize.css')}}"> 


    <div class="container-fluid no-padding h-100">
            <div class="row flex-row h-100 bg-white">                
                <!-- Begin Left Content -->
                <div class="col-xl-8 col-lg-6 col-md-5 no-padding">
                    <div class="elisyam-bg background-01" >                            
                        <div class="elisyam-overlay" style="background: url('{{asset('logo/bg.jpg')}}');background-size: cover;background-repeat: no-repeat;"></div>
                        <div class="authentication-col-content mx-auto">
                            @if(config('app.env') == 'demo')
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h4>Demo Shops <small><i> Demos are for example purpose only, this application <u>can be used in many other similar businesses.</u></i></small></h4></div>
                                        <div class="panel-body">
                                            <div class="col-md-12 text-center">
                                                        <a href="?demo_type=all_in_one" class="btn btn-app bg-olive" data-toggle="tooltip" title="Showcases all feature available in the application." >
                                                            <i class="fa fa-star"></i>
                                                        All In One</a>
                                                        <a href="?demo_type=pharmacy" class="btn bg-maroon btn-app" data-toggle="tooltip" title="Shops with products having expiry dates." >
                                                        <i class="fa fa-medkit"></i>
                                                        Pharmacy</a>
                                                        <a href="?demo_type=services" class="btn bg-orange btn-app" data-toggle="tooltip" title="For all service providers like Web Development, Restaurants, Repairing, Plumber, Salons, Beauty Parlors etc.">
                                                        <i class="fa fa-wrench"></i>
                                                        Multi-Service Center</a>
                                                        <a href="?demo_type=electronics" class="btn bg-purple btn-app" data-toggle="tooltip" title="Products having IMEI or Serial number code." >
                                                        <i class="fa fa-laptop"></i>
                                                        Electronics & Mobile Shop</a>
                                                        <a href="?demo_type=super_market" class="btn bg-navy btn-app" data-toggle="tooltip" title="Super market & Similar kind of shops." >
                                                        <i class="fa fa-shopping-cart"></i>
                                                        Super Market</a>
                                                        <a href="?demo_type=restaurant" class="btn bg-red btn-app" data-toggle="tooltip" title="Restaurants, Salons and other similar kind of shops." >
                                                        <i class="fa fa-cutlery"></i>
                                                        Restaurant</a>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="alert alert-success alert-dismissible">
                                                    <i class="icon fa fa-plug"></i> Premium optional modules:
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12">
                                                <a href="?demo_type=superadmin" class="btn bg-red-active btn-app" data-toggle="tooltip" title="SaaS & Superadmin extension Demo">
                                                    <i class="fa fa-university"></i>
                                                    SaaS / Superadmin</a>

                                                <a href="?demo_type=woocommerce" class="btn bg-woocommerce btn-app" data-toggle="tooltip" title="WooCommerce demo user - Open web shop in minutes!!" style="color:white !important">
                                                    <i class="fa fa-wordpress"></i>
                                                    WooCommerce</a>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>           
                            @else
                            
                            <h1 class="gradient-text-01 color1">
                                
                                @lang('lang_v1.welcome')
                            </h1>
                            <span class="description color2">
                                <!--@lang('lang_v1.welcomeText')-->                                
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End Left Content -->
                <!-- Begin Right Content -->
                <div class="col-xl-4 col-lg-6 col-md-7 my-auto no-padding" style="padding-bottom: 20px !important;background: #fff;">
                    
                            <!-- Begin Form -->
                    <div class="authentication-form mx-auto"  >
                        <div class="row" style="margin-bottom:30px;">
                            <div class="col-md-12">
                                <img src="{{asset('logo/logo.png')}}" class="img-responsive" >
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class=" col-xs-6">
                                        <select class="form-control input-sm" id="change_lang">
                                            @foreach(config('constants.langs') as $key => $val)
                                                <option value="{{$key}}" 
                                                    @if( (empty(request()->lang) && config('app.locale') == $key) 
                                                    || request()->lang == $key) 
                                                        selected 
                                                    @endif
                                                >
                                                    {{$val['full_name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" col-xs-6">
                                        <center><a class="form-control btn btn-info" style="border-radius:5px;color:#fff;height: calc(2.85rem + 2px);" href="{{url('pricing')}}">@lang('lang_v1.pricing')</a></center>
                                </div>
                                </div>
                                
                            </div>
                    </div>
                        <h3>@lang('lang_v1.sign_in')</h3><br>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                                @php
                                    $username = old('username');
                                    $password = null;
                                    if(config('app.env') == 'demo'){
                                        $username = 'admin';
                                        $password = '123456';

                                        $demo_types = array(
                                            'all_in_one' => 'admin',
                                            'super_market' => 'admin',
                                            'pharmacy' => 'admin-pharmacy',
                                            'electronics' => 'admin-electronics',
                                            'services' => 'admin-services',
                                            'restaurant' => 'admin-restaurant',
                                            'superadmin' => 'superadmin',
                                            'woocommerce' => 'woocommerce_user'
                                        );
                                        if( !empty($_GET['demo_type']) && array_key_exists($_GET['demo_type'], $demo_types) ){
                                            $username = $demo_types[$_GET['demo_type']];
                                        }
                                    }
                                @endphp
                            <div class="group material-input">	                               
                                <input type="hidden" name="rgister_type" value="{{Session::has('rgister_type') ==1?1:'0'}}">                                
                                <input type="text" class="form-control" name="username" value="{{$username}}" required autofocus>
                                <span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang_v1.username')</label>
                                @if ($errors->has('username'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="group material-input">
                                <input type="password" class="form-control" name="password" value="{{ $password }}" required>
                                <span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang_v1.password')</label>
                                @if ($errors->has('password'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                        <div class="row">
                            <div class="col text-left">
                                <div class="styled-checkbox">
                                    <input type="checkbox" id="remeber" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remeber">@lang('lang_v1.remember_me')</label>
                                </div>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('password.request') }}@if(isset($_GET['lang']))?lang={{$_GET['lang']}}  @endif">@lang('lang_v1.forgot_your_password')</a>
                            </div>
                        </div>
                        <div class="sign-btn text-center">
                            <button class="btn btn-lg btn-gradient-01">
                                Sign in
                            </button>
                        </div>
                        <div class="register">
                            @lang('lang_v1.no_account') <br>
                            <a href="{{ route('business.getRegister') }}@if(isset($_GET['lang']))?lang={{$_GET['lang']}}  @endif">{{ __('business.register_now') }}</a>
                        </div>
                                
                    </form>
                  </div>   
                  
                    <!-- End Form -->                        
                </div>
                <!-- End Right Content -->
            </div>
            <!-- End Row -->
        </div>


@stop

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('login') }}?lang=" + $(this).val();
        });
    })
</script>
        <!-- Begin Vendor Js -->
        <script src="{{asset('logpage/vendors/js/base/jquery.min.js')}}"></script>
        <script src="{{asset('logpage/vendors/js/base/core.min.js')}}"></script>
        <!-- End Vendor Js -->
        <!-- Begin Page Vendor Js -->
        <script src="{{asset('logpage/vendors/js/app/app.min.js')}}"></script>
        <!-- End Page Vendor Js -->
        @if(Session::has('status'))
        <div class="message">
            @php $status = Session::get('status'); @endphp
            @if($status['success'] == 1)
            <span class="fa fa-check fa-lg"></span> &nbsp; {{$status['msg']}}
            @else
            <span class="fa fa-exclamation-circle fa-lg"></span> &nbsp; {{$status['msg']}}
            @endif
        </div>

        <style>
            .message{          
                background: {{$status['success'] == 1?'#32CD32;':'#FF6347;'}}
                padding: 20px 30px 20px 40px;
                top:0;
                right:0;
                position: absolute;
                z-index: 1030;
                color:#fff;
                border-radius: 5px;
                transition: 1s ease-in-out;
            }
        </style>
        <script>
            $(document).ready(function(){
                
                 $(".message").show().delay(3000).queue(function(n) {
                    $(this).fadeOut('slow'); n();
                });
               
            });
        </script>
        @endif
@endsection

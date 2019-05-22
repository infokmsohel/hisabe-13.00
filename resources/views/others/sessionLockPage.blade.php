<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lock Session</title>        
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Google Fonts -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
    <link rel="stylesheet" href="{{asset('logpage/vendors/css/base/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('logpage/vendors/css/base/elisyam-1.5.min.css')}}"> 
    </head>
    <body class="bg-fixed-01">
        <div id="preloader">
            <div class="canvas">
                <img src="{{asset('logo/logo.png')}}" alt="logo" class="loader-logo">
                <div class="spinner"></div>   
            </div>
        </div>
        <!-- End Preloader -->
        <!-- Begin Section -->
        <div class="container-fluid h-100 overflow-y">
            <div class="row flex-row h-100">
                <div class="col-12 my-auto">
                    <div class="lock-form mx-auto">
                        <div class="photo-profil"> 
                        @if(file_exists(Auth::user()->profilePic))                           
                            <img src="{{ asset(Auth::user()->profilePic) }}" alt="Business Logo" class="img-fluid rounded-circle">
                        @else
                            <img src="{{asset('logo/logo.png')}}" class="img-fluid rounded-circle">
                        @endif
                        </div>
                        <h3>Your Session Is Locked</h3>
                        
                        {!! Form::open(['url'=>'unlock/session','method'=>'post']) !!}
                            <div class="group material-input">
                                <input type="password" required name="password">
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang_v1.password')</label>
                                @if(Session::has('error'))
                                <div class="text-danger text-center">
                                    {{Session::get('error')}}
                                </div>
                                @endif
                            </div>
                            <div class="button text-center">
                                <button class="btn btn-lg btn-gradient-01" type="submit">Unlock</button>
                                
                            </div>
                        {!! Form::close() !!}
                        
                        <div class="back">
                            <a href="{{url('logout')}}">It is not you ?</a>
                        </div>
                    </div>      
                </div>
            </div>
            <!-- End Container -->
        </div> 


<!-- Begin Vendor Js -->
        <script src="{{asset('logpage/vendors/js/base/jquery.min.js')}}"></script>
        <script src="{{asset('logpage/vendors/js/base/core.min.js')}}"></script>
        <!-- End Vendor Js -->
        <!-- Begin Page Vendor Js -->
        <script src="{{asset('logpage/vendors/js/app/app.min.js')}}"></script>
        <!-- End Page Vendor Js -->
        {{ TawkTo::widgetCode() }}
</body> 
</html>


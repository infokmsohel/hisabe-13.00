<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reset Password</title>        
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
    <link rel="stylesheet" href="{{asset('css/customize.css')}}"> 
    </head>
    <body class="bg-fixed-02">
        <div id="preloader">
            <div class="canvas">
                <img src="{{asset('logo/logo.png')}}" alt="logo" class="loader-logo">
                <div class="spinner"></div>   
            </div>
        </div>
        <div class="container-fluid h-100 overflow-y">
            <div class="row flex-row h-100">
                <div class="col-12 my-auto">
                    <div class="password-form mx-auto">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                        <div class="logo-centered">
                             <!--logo-->
                        </div>
                        <h3>@lang('lang_v1.reset_password')</h3>
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                            <div class="group material-input">
				<input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
				<span class="highlight"></span>
				<span class="bar"></span>
				<label>@lang('lang_v1.email_address') or @lang('lang_v1.username')</label>
                                 @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>                                    
                                @endif
                                @if(Session::has('username'))
                                <div class="help-block text-center text-danger" style="margin-top: 10px;">
                                    {{Session::get('username')}}
                                </div>
                                @endif
                            </div>
                            <div class="button text-center">
                                <button class="btn btn-lg btn-gradient-01" type="submit">
                                    @lang('lang_v1.send_password_reset_link')
                                </button>
                            </div>
                        </form>
                        
                        <div class="back">
                            <a href="{{route('login')}}">Sign In</a>
                        </div>
                    </div>        
                </div>
                <!-- End Col 
            </div>
            <!-- End Row -->
        </div>
    </div>


<!-- Begin Vendor Js -->
        <script src="{{asset('logpage/vendors/js/base/jquery.min.js')}}"></script>
        <script src="{{asset('logpage/vendors/js/base/core.min.js')}}"></script>
        <!-- End Vendor Js -->
        <!-- Begin Page Vendor Js -->
        <script src="{{asset('logpage/vendors/js/app/app.min.js')}}"></script>
        <!-- End Page Vendor Js -->
</body> 
</html>
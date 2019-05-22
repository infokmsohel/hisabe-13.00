<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Account Verification</title>        
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
    <body class="bg-fixed-02">
        <!-- Begin Preloader -->
        <div id="preloader">
            <div class="canvas">
                <img src="{{asset('logo/logo.png')}}" alt="logo" class="loader-logo">
                <div class="spinner"></div>   
            </div>
        </div>
        <!-- End Preloader -->
        <!-- Begin Container -->
        <div class="container-fluid h-100 overflow-y">
            <div class="row flex-row h-100">
                <div class="col-12 my-auto">                   
                    <div class="mail-confirm mx-auto">
                        @if(Session::has('message'))
                        <div class="alert alert-info text-center">
                            {{Session::get('message')}}
                        </div>
                        @endif
                        <div class="animated-icon">
                            <div class="gradient"></div>
                            <div class="icon"><i class="la la-at"></i></div>
                        </div>
                        <h3>Confirm your email address!</h3>
                        <p>
                            A confirmation email has been sent to <a href="#">{{Auth::user()->email}}</a> 
                        </p>
                        <p>
                            Check your inbox and click on the link to confirm your email address.
                        </p>
                        <p class="text-center">OR</p>
                        <div class="button text-center">
                            <a href="{{url('resend/confirmation-link')}}" class="btn btn-lg btn-gradient-01">
                                Resend Confirmation Link
                            </a>
                        </div>
                    </div>        
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
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


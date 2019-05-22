<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#email-design{
			font-size:19px;width:60%;margin:0px auto;margin-top:10px;border:8px solid #1DC6BC;background: #fff;padding:20px;color:#666;
		}
                .btn{padding:8px 12px;text-align: center;background:#1DC6BC;color:#fff !important;text-decoration: none;margin-top: 20px;border-radius: 5px;}
	</style>
</head>
<body>
	<div id="email-design"> 
            <h3 style="color:#1DC6BC;"><b><center> {!! $subject !!}</center></b></h3>
            {!! $messagebody !!}<br> <br>
            <center><a class="btn" href="{{$link}}">Verify Now</a></center><br>       
            <p style="text-align: center;"> Regards by <br>{{config('app.name')}}</p>
        </div>
</body>
</html>
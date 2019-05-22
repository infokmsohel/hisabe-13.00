@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    {!! Charts::styles(['highcharts']) !!}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <div class="panel panel-success" style="margin-top: 20px;">
                <div class="panel-heading">
                    <h4 class="panel-title">Confirmation</h4>
                </div>
                <div class="panel-body">
                    @if(isset($statusCode) && $statusCode == 200)
                    <div class="text-success text-center">
                        <span class="fa fa-check-circle fa-4x"></span><br>
                        <h3 class="text-success">{{$status}}</h3>
                        <h3 class="text-info">
                            @if(isset($tran_id))
                            Transaction is successfully completed.<br>
                            Your Transaction ID is :<b>{{$tran_id}}</b><br>
                                Thank You for using HISABE
                            @endif
                        </h3>
                        <h5>Thank You for using HISABE</h5>
                        
                    </div>
                    @elseif(isset($statusCode) && $statusCode == 400)
                    <div class="text-danger text-center">
                        <span class="fa fa-times fa-4x"></span><br>
                        <h3 class="text-success">{{$status}}</h3>
                        <h5>Thank you For Staying with Us.</h5>
                        
                    </div>
                    @else
                    <div class="text-danger text-center">
                        <span class="fa fa-times-circle fa-4x"></span><br>
                        <h3>Dear Customer, Your are trying to direct Access to this Page.</h3>
                    </div>
                    @endif
                    <br>
                    <div class="text-center">
                        <a href="{{url('/home')}}" class="btn btn-default">Go To Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




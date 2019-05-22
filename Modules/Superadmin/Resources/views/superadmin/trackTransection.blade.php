@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | Track Transaction' )

@section('content')
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="text-info">
                    @lang('lang_v1.trac_transaction'):
                </h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'superadmin/track-now','method'=>'post','class'=>'form-horizontal']) !!}
                <div class="form-group">
                    <div class="col-sm-5 text-right">
                        <label>@lang('lang_v1.input_transaction')</label>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" name="tran_id" required class="form-control" placeholder="Input Transaction ID">
                    </div>                    
                    <div class="form-group">
                        <div class="col-sm-5 text-right"></div>
                        <div class="col-sm-7" style="margin-top: 10px !important;">
                            <button type="submit" class="btn btn-info">Show Details</button>
                        </div>
                    </div>
                </div>
                
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@if(isset($data))
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="text-info">
                    @lang('lang_v1.transaction_info')
                </h3>
            </div>
            <div class="panel-body">
                @if($data['APIConnect'] == "DONE")
                    @if($data['no_of_trans_found'] !=0)
                        @php $details = $data['element']; @endphp
                        @foreach($details as $dt)
                            Validate id : {{$dt['val_id']}} <br>
                            Status : {{$dt['status']}} <br>
                            Validated on : {{$dt['validated_on']}} <br>
                            Amount : {{$dt['currency_amount']}} {{$dt['currency_type']}} <br>
                            Currency Rate: {{$dt['currency_rate']}}<br>
                            Transection date : {{$dt['tran_date']}} <br>
                            Transection ID : {{$dt['tran_id']}} <br>
                            Total Amount : {{$dt['amount']}} <br>
                            Bank Name: {{$dt['bank_gw']}}<br>
                            Card Type : {{$dt['card_type']}} <br>
                            Card No: {{$dt['card_no']}}
                        @endforeach
                    @else
                    <div class="alert alert-danger">
                        @lang('lang_v1.transaction_not')
                    </div>
                    @endif
                @else
                <div class="alert alert-danger">
                    Connection Error with Server
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('javascript')
@endsection
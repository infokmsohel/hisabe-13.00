@extends('layouts.app')
@section('title','Custom Payment')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4>{{__('account.money_receipt_history')}}</h4>                    
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-bordered" id="payment">
                        <thead>
                            <tr>
                                 <th>{{__('account.receipt_no')}}</th>
                                <th>{{__('account.customer_name')}}</th>
                                <th>{{__('account.address')}}</th>
                                <th>{{__('account.phone_no')}}</th>                              
                                <th>{{__('account.payment_method')}}</th>
                                <th>{{__('account.payment_amt')}}</th>
                                <th>{{__('account.payment_note')}}</th>
                                <th>{{__('account.date')}}</th>
                                <th>{{__('messages.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>{{$payment->customerName}}</td>
                                <td>{{$payment->customerAddress}}</td>
                                <td>{{$payment->phoneNo}}</td>                                
                                <td>{{$payment->customPaymentMethod}}</td>
                                <td>{{number_format($payment->paymentAmount)}}</td>
                                <td>{{$payment->customPaymentNote}}</td>
                                <td>{{$payment->created_at}}</td>
                                <td>
                                    <a href="{{url('print/custom-payment/'.$payment->id)}}" class="btn btn-primary btn-sm" title="Print"> <span class="fa fa-print"></span> </a>                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready( function () {
        $('#payment').DataTable();
    });
</script>
@endsection

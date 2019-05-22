@extends('layouts.app')
@section('title','Advance Payment')
@section('content')
<!--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" />-->
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4>@lang( 'account.advance_payment' )</h4>
                        </div>
                        <div>
                            <button type="button" class="pull-right btn btn-primary m-5" data-toggle="modal" data-target="#payment">@lang( 'account.add_new_payment' )</button>
                        </div>                        
                    </div>                    
                </div>
                <div class="panel-body">
                    <table class="table table-responsive" id="advancePayment">
                        <thead>
                            <tr>
                                <th>@lang('account.invoice_no')</th>
                                <th>@lang('account.customer_name')</th>
                                <th>@lang('account.address')</th>
                                <th>@lang('account.product_name')</th>
                                <th>@lang('account.payment_note')</th>
                                <th>@lang('account.payment_amt')</th>
                                <th>@lang('account.date')</th>
                                <th>@lang('account.payment_status')</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>{{$payment->customerName}}</td>
                                <td>{{$payment->customerAddress}}</td>
                                <td>{{$payment->productName}}</td>
                                <td>{{$payment->note}}</td>
                                <td>{{number_format($payment->amount)}}</td>
                                <td>{{$payment->created_at->format('d/m/Y')}}</td>
                                <td>{{$payment->paymentStatus ==1?'Paid':'Advance Payment'}}</td>
                                <td>
                                    <a href="{{url('print/advance/'.$payment->id)}}" class="btn btn-primary btn-sm" title="Print"> <span class="fa fa-print"></span> </a>
                                    <a href="{{url('edit/advance/'.$payment->id)}}" class="btn btn-info btn-sm" title="Edit"> <span class="fa fa-edit"></span> </a>                                    
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
@include('advancePayment.payment')
@stop
@section('javascript')
<!--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>-->
<script type="text/javascript">
    @if(isset($data->id))
        $('#payment').modal('show');
    @endif
    $(document).ready( function () {
        $('#advancePayment').DataTable();
    });
</script>
@endsection


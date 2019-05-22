<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{__('account.advance_payment')}}</h4>
      </div>
        {!! Form::open(['url'=>'AdvancePayment','method'=>'post']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>{{__('account.customer_name')}}*</label>
                        <input type="hidden" name="id" value="{{isset($data->id)?$data->id:'0'}}">
                        <input type="text" value="{{isset($data->id)?$data->customerName:''}}" name="customerName" placeholder="{{__('account.customer_name')}}" required class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>{{__('account.address')}}*</label>
                        <input type="text" value="{{isset($data->id)?$data->customerAddress:''}}" name="customerAddress" placeholder="{{__('account.address')}}" required class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>{{__('account.product_name')}}*</label>
                        <input type="text" name="productName" value="{{isset($data->id)?$data->productName:''}}" placeholder="{{__('account.product_name')}}" required class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>{{__('account.payment_note')}}</label>
                        <input type="text" value="{{isset($data->id)?$data->note:''}}" name="note" placeholder="{{__('account.payment_note')}}"  class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6">
                        <label>{{__('account.payment_amt')}}*</label>
                        <input type="number" name="amount" value="{{isset($data->id)?$data->amount:''}}" placeholder="{{__('account.payment_amt')}}" required class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>{{__('account.payment_status')}}</label>
                        <select name="paymentStatus" required class="form-control">
                            <option value="0" {{isset($data->id) && $data->paymentStatus == 0?'selected':''}}>Advance Payment</option>
                            <option value="1" {{isset($data->id) && $data->paymentStatus == 1?'selected':''}} >Paid</option>
                        </select>
                    </div>
                </div>
            </div>            
        </div>
        <div class="modal-footer">   
            <div class="form-group">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('account.close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('account.save_change')}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
  </div>
</div>



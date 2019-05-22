<!--Custom Payment Modal -->
<div class="modal fade" id="customPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">{{__('account.custom_payment')}}</h4>
        </div>
        {!! Form::open(['method'=>'post','url'=>'custom-payment'])!!}
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>{{__('account.customer_name')}}*</label>
                        <input type="text" name="customerName" class="form-control" placeholder="{{__('account.customer_name')}}" required>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>{{__('account.address')}}*</label>
                        <input type="text" name="customerAddress" class="form-control" placeholder="{{__('account.address')}}" required>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <label>{{__('account.phone_no')}}*</label>
                        <input type="text" name="phoneNo" class="form-control" placeholder="{{__('account.phone_no')}}" required>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>{{__('account.item_name')}}*</label>
                        <input type="text" name="itemName1" class="form-control" placeholder="{{__('account.item_name')}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>{{__('account.item_quantity')}}*</label>
                        <input type="number" min="1" name="itemQty1" class="form-control" placeholder="{{__('account.item_quantity')}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>{{__('account.price')}}*</label>
                        <input type="number" min="1" name="itemPrice1" class="form-control" placeholder="{{__('account.price')}}" required>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label>{{__('account.total_price')}}*</label>
                        <input type="number" min="1" name="totalPrice1" class="form-control" placeholder="{{__('account.total_price')}}" required>
                    </div>
                </div>
            </div>
            <input id="count" name="count" value="1" type="hidden">
            <fieldset></fieldset>
            <hr/>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{__('account.payment_method')}}*</label>
                        <select name="customPaymentMethod" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="bkash">bkash</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Pay Order">Pay Order</option>
                            <option value="Bank Deposit">Bank Deposit</option>
                        </select>
                    </div>
                </div>
                @if(count($accounts)>1)
                <div class="col-sm-6 col-md-4">
                    <label>Select Account</label>
                    {!! Form::select("customPaymentAccount" ,$accounts, !empty($payment_line['account_id']) ? $payment_line['account_id'] : '' , ['class' => 'form-control','required']); !!}
                </div>
                @endif
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>{{__('account.payment_note')}}</label>
                        <input type="text" name="customPaymentNote" class="form-control">
                    </div>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{__('account.close')}}</button>
            <button type="button" id="remove_field" class="btn btn-danger" >{{__('account.remove_field')}}</button>
            <button type="button" id="add_field" class="btn btn-info" >{{__('account.add_new_field')}}</button>             
            <button type="submit" class="btn btn-primary"><span class="fa fa-print fa-lg"></span> Print</button>
        </div>
        {!! Form::close()!!}
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
        $('#remove_field').hide();
        var i = 1;
        var x = document.getElementById('count');
        $(document).on("click", "#add_field", function(){  
            i++;
        $("form fieldset").append('\n\
        <div class="row" id="newblock'+i+'">\n\
                <div class="col-sm-6 col-md-3">\n\
                    <div class="form-group">\n\
                        <label>{{__('account.item_name')}}*</label>\n\
                        <input type="text" name="itemName'+i+'" class="form-control" placeholder="{{__('account.item_name')}}" required>\n\
                    </div>\n\
                </div>\n\
                <div class="col-sm-6 col-md-3">\n\
                    <div class="form-group">\n\
                        <label>{{__('account.item_quantity')}}*</label>\n\
                        <input type="text" name="itemQty'+i+'" class="form-control" placeholder="{{__('account.item_quantity')}}" required>\n\
                    </div>\n\
                </div>\n\
                <div class="col-sm-6 col-md-3">\n\
                    <div class="form-group">\n\
                        <label>{{__('account.price')}}*</label>\n\
                        <input type="text" name="itemPrice'+i+'" class="form-control" placeholder="{{__('account.price')}}" required>\n\
                    </div>\n\
                </div>\n\
                <div class="col-sm-6 col-md-3">\n\
                    <div class="form-group">\n\
                        <label>{{__('account.total_price')}}*</label>\n\
                        <input type="text" name="totalPrice'+i+'" class="form-control" placeholder="{{__('account.total_price')}}" required>\n\
                    </div>\n\
                </div>\n\
            </div>');
        x.value=i;
        $('#remove_field').show();
        
    });
    $('#remove_field').click(function(){
        $('#newblock'+i).remove();
        i--;
        x.value=i;
        if(i==1){
            $('#remove_field').hide();
        }
    });
    
    </script>


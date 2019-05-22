            
            <div class="row">
                <div class="col-xs-7">
                    <div>
                        @if(!empty($receipt_details->logo))
                            <img src="{{$receipt_details->logo}}" class="img img-responsive" style="width:160px;height:80px;">
                        
                        @endif
                    </div>
                </div>
                <div class="col-xs-5">                    
                    <h3>INVOICE NO: {{$receipt_details->invoice_no}}</h3>  
                    Date: {{$receipt_details->invoice_date}}
                </div>
            </div>
            <div class="row">
                    <div class="col-xs-7">
                        <div>From,</div>    
                        <div>
                            @if(!empty($receipt_details->display_name))
				{{$receipt_details->display_name}}
                            @endif
                        </div>
                        <div>
                            @if(!empty($receipt_details->address))
                                {{$receipt_details->address}}
                            @endif
                        </div>    
                        <div>Phone No: {{$business->mobile}}</div>
                    </div>
                    <div class="col-xs-5">
                        
                        <div>To</div>
                        <div>{{!empty($receipt_details->customer_name)?'Customer Name: '.$receipt_details->customer_name:''}}</div>
                        <div>{{!empty($receipt_details->customer_fatherName)?'Fathers Name: '.$receipt_details->customer_fatherName:''}}</div>
                        <div>{!! !empty($receipt_details->customer_info)?$receipt_details->customer_info:'' !!}</div>
                        <div>{{!empty($receipt_details->customer_mobileNo)?$receipt_details->customer_mobileNo:''}}</div>
                    </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
		
                    <table class="table table-responsive table-bordered">
			<thead>
				<tr>
                    <th>Serial No</th>
					<th>{{$receipt_details->table_product_label}}</th>
					<th>{{$receipt_details->table_qty_label}}</th>
					<th>{{$receipt_details->table_unit_price_label}}</th>
					<th>{{$receipt_details->table_subtotal_label}}</th>
				</tr>
			</thead>
			<tbody>
                            <?php $i=0;?>
				@forelse($receipt_details->lines as $line)
					<tr>
                                            <td>{{++$i}}</td>
						<td style="word-break: break-all;">
                            {{$line['name']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif @if(!empty($line['cat_code'])), {{$line['cat_code']}}@endif
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif 
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif 
                            <br>
                            @if($line['productType'] == 1)
                                @foreach($customFields as $field)
                                {{$field->customFieldName }} : {{$field->customFieldValue}} <br>
                                @endforeach
                            @endif
                        </td>
						<td>{{$line['quantity']}} {{$line['units']}} </td>
						<td>{{$line['unit_price_inc_tax'] < 1 ?'Gift':$line['unit_price_inc_tax'] }}</td>
						<td>{{$line['line_total'] < 1 ?'Gift':$line['line_total']}}</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
		                            @if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif 
		                        </td>
								<td>{{$modifier['quantity']}} {{$modifier['units']}} </td>
								<td>{{$modifier['unit_price_inc_tax']}}</td>
								<td>{{$modifier['line_total']}}</td>
							</tr>
						@endforeach
					@endif
				@empty
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
				@endforelse
                            </tbody>
                        </table>
                </div>
            </div>        
            
            <div class="row">
                <div class="total">
                    <div class="col-xs-7">
                        @if($receipt_details->total_due || empty($receipt_details->total_due))
                            <div class="text-size bold">{!! $receipt_details->total_due_label !!} <span> {{$receipt_details->total_due}} </span></div>                        
                        @endif
                    </div>
                    <div class="col-xs-2">                            
                        <div class="text-size bold">{{$receipt_details->subtotal_label}}</div>
                        @if(!empty($receipt_details->shipping_charges))
                            <div class="text-size bold">{{$receipt_details->shipping_charges_label}}</div>
                        @endif
                        @if( !empty($receipt_details->discount) )
                            <div class="text-size bold">{{$receipt_details->discount_label}}</div>
                        @endif
                        @if( !empty($receipt_details->tax) )
                            <div class="text-size bold">{{$receipt_details->tax_label}}</div>
                        @endif
                        <div class="text-size grand-font bold">{!! $receipt_details->total_label !!}</div>                    
                    </div>
                    <div class="col-xs-2">
                        <div class="text-size bold">{!! $receipt_details->subtotal !!}</div>
                        @if(!empty($receipt_details->shipping_charges))
                            <div class="text-size bold">{{$receipt_details->shipping_charges}}</div>
                        @endif
                        @if( !empty($receipt_details->discount) )
                            <div class="text-size bold">{{$receipt_details->discount}}</div>
                        @endif
                        @if( !empty($receipt_details->tax) )
                            <div class="text-size bold">{{$receipt_details->tax}}</div>
                        @endif
                        <div class="text-size grand-font bold">{{$receipt_details->total}} </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    Amount in word: {{ucwords($inWord)}} Only.
                </div>                
            </div>
            <br>
            <div class="row">
                <div class="invoice-total">
                    <div class="col-xs-12">
                        <div style="font-size:13px;">I agree with Term And Conditions</div>
                        @if(!empty($receipt_details->footer_text))
                        <div>
                            {!! $receipt_details->footer_text !!}
                        </div> 
                        @endif
                    </div>  
                </div>
            </div>
                <div class="row bottom-space">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-5">
                                <div>                                    
                                    @if(!empty($receipt_details->payments))
                                        @foreach($receipt_details->payments as $payment)
                                            Payment Method: {{$payment['method']}}<br>
                                            Pay Amount : {{$payment['amount']}}                                            
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                             <div class="col-xs-4">
                                <br><br>
                                ...................................<br>
                                Customer Signature
                                
                            </div>
                            <div class="col-xs-4">
                                <br><br>
                                ...................................<br>                                
                                Authorised Signature/Seal
                                
                            </div>
                            <div class="col-xs-4">
                                <br><br>
                                ...................................<br>
                                Sales Person Signature
                                
                            </div>                                
                        </div>                                                
                    </div>
                </div>
            <style type="text/css">
                table tr td{
                    padding-top:0px;
                    padding-bottom: 0px;
                    margin-top: 0px;
                    margin-bottom: 0px;
                    
                }
                .page-break{
                    page-break-after: always;
                }
                .width{
                    width:25%;
                }
                #bank-copy tr td {
                    font-size: 16px;
                    padding-top: 15px;
                    padding-bottom: 15px;
                }
            </style>
        @if(count($customFields)>0)
            <div class="page-break"></div>
            
            
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center"></h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped table-bordered" id="bank-copy">
                        <tbody>
                             <tr>
                                <td class="width">Mobile No</td>
                               <td>{{!empty($receipt_details->customer_mobileNo)?$receipt_details->customer_mobileNo:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Name</td>
                               <td>{{!empty($receipt_details->customer_name)?$receipt_details->customer_name:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Father's Name</td>
                                <td>{{!empty($receipt_details->customer_fatherName)?$receipt_details->customer_fatherName:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Address</td>
                                <td>{!! !empty($receipt_details->customer_name)?$receipt_details->customer_info:'' !!}</td>
                            </tr>
                            @foreach($customFields as $field)
                            <tr>
                                <td class="width">{{$field->customFieldName}}</td>
                                <td>{{$field->customFieldValue}}</td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <td class="width">Note</td>
                                <td></td>
                            </tr>                                                    
                        </tbody>  
                    </table>
                </div>
            </div>
            
             <div class="page-break"></div>
            
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-responsive table-bordered" id="bank-copy">
                        <tbody>
                            <tr>
                            <td class="width">Mobile No</td>
                               <td>{{!empty($receipt_details->customer_mobileNo)?$receipt_details->customer_mobileNo:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Name</td>
                               <td>{{!empty($receipt_details->customer_name)?$receipt_details->customer_name:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Father's Name</td>
                                <td>{{!empty($receipt_details->customer_fatherName)?$receipt_details->customer_fatherName:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Address</td>
                                <td>{!! !empty($receipt_details->customer_name)?$receipt_details->customer_info:'' !!}</td>
                            </tr>
                            @foreach($customFields as $field)
                            <tr>
                                <td class="width">{{$field->customFieldName}}</td>
                                <td>{{$field->customFieldValue}}</td>
                            </tr>
                            @endforeach                            
                            <tr>
                                <td class="width">Note</td>
                                <td></td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>  
            </div>
            
            <br>
            <div class="page-break"></div>
            
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center"><b>{{$business->bname}}</b></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        SD:
                    </div>
                    <div class="col-xs-6 text-right">
                        Date: {{Carbon\Carbon::parse($receipt_details->invoice_date)->format('m/d/Y')}}
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-responsive table-bordered" id="bank-copy">
                            <tr>
                                <td class="width">Name</td>
                               <td>{{!empty($receipt_details->customer_name)?$receipt_details->customer_name:''}}</td>
                            </tr>
                            <tr>
                                <td class="width">Mobile</td>
                                <td>{{!empty($receipt_details->customer_mobileNo)?$receipt_details->customer_mobileNo:''}}</td>
                            </tr>
                            @foreach($customFields as $field)
                            <tr>
                                <td class="width">{{$field->customFieldName}}</td>
                                <td>{{$field->customFieldValue}}</td>
                            </tr>
                            @endforeach                            
                            <tr>
                                <td class="width">2 years/ 10 Years</td>
                                <td></td>
                            </tr>
                        
                    </table>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered" id="bank-copy">
                        <tr>
                            <th><h3>Brand new motor bike registration free</h3></th>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif    
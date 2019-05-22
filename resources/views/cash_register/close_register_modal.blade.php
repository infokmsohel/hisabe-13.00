<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action('CashRegisterController@postCloseRegister'), 'method' => 'post' ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">@lang( 'cash_register.current_register' ) ( {{ \Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A') }} - {{ \Carbon::now()->format('jS M, Y h:i A') }})</h3>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">

                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">@lang( 'cash_register.current_opening_balance' )</h3>
                        </div>

                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td> @lang('cash_register.previous_closing_cash'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $closing_amount }} </td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.cash_forwarded'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $cashForward  }} TK</td>
                                </tr>
                                <tr>
                                    <td>  @lang('cash_register.cash_in_hand'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->cash_in_hand  }} TK</td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.opening_balance'):</td>
                                    <td class="display_currency success" data-currency_symbol="true"><strong>{{ $register_details->cash_in_hand+ $cashForward }}</strong> </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">@lang('cash_register.expense_register')</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        @lang('cash_register.cash_expense'):
                                    </td>
                                    <td>
                                        <span class="display_currency" data-currency_symbol="true">{{ $expenses }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        @lang('cash_register.bank_expense'):
                                    </td>
                                    <td>
                                        <span class="display_currency" data-currency_symbol="true">{{ $bankExpenses }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        @lang('cash_register.check_expense'):
                                    </td>
                                    <td>
                                        <span class="display_currency" data-currency_symbol="true">{{ $checkExpenses }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        @lang('cash_register.total_cash_purchase'):
                                    </td>
                                    <td>
                                        <span class="display_currency" data-currency_symbol="true">{{ $purchase }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        @lang('cash_register.total_refund')
                                    </th>
                                    <td>
                                        <b><span class="display_currency" data-currency_symbol="true">{{ $register_details->total_refund }}</span></b><br>
                                        <small>
                                            @if($register_details->total_cash_refund != 0)
                                                Cash: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash_refund }}</span><br>
                                            @endif
                                            @if($register_details->total_cheque_refund != 0)
                                                Cheque: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque_refund }}</span><br>
                                            @endif
                                            @if($register_details->total_card_refund != 0)
                                                Card: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_card_refund }}</span><br>
                                            @endif
                                            @if($register_details->total_bank_transfer_refund != 0)
                                                Bank Transfer: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer_refund }}</span><br>
                                            @endif
                                            @if(config('constants.enable_custom_payment_1') && $register_details->total_custom_pay_1_refund != 0)
                                                @lang('lang_v1.custom_payment_1'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_1_refund }}</span>
                                            @endif
                                            @if(config('constants.enable_custom_payment_2') && $register_details->total_custom_pay_2_refund != 0)
                                                @lang('lang_v1.custom_payment_2'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_2_refund }}</span>
                                            @endif
                                            @if(config('constants.enable_custom_payment_3') && $register_details->total_custom_pay_3_refund != 0)
                                                @lang('lang_v1.custom_payment_3'): <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_custom_pay_3_refund }}</span>
                                            @endif
                                            @if($register_details->total_other_refund != 0)
                                                Other: <span class="display_currency" data-currency_symbol="true">{{ $register_details->total_other_refund }}</span>
                                            @endif
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        @lang('cash_register.total_expense'):
                                    </td>
                                    <td>
                                        <span class="display_currency success" data-currency_symbol="true">{{ $expenses+$purchase+$register_details->total_cash_refund+$checkExpenses+$bankExpenses }}</span>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">@lang( 'cash_register.purchase_register' )</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td> @lang('cash_register.cash_purchase'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $purchase }} </td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.cheque_purchase'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $chequePurchase  }}</td>
                                </tr>
                                <tr>
                                    <td>  @lang('cash_register.card_purchase'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $cardPurchase  }} TK</td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.balance_purchase'):</td>
                                    <td class="display_currency " data-currency_symbol="true"><strong>{{ $balancePurchase }}</strong> </td>
                                </tr>

                                <tr>
                                    <td> @lang('cash_register.bank_purchase'):</td>
                                    <td class="display_currency " data-currency_symbol="true"><strong>{{ $bankPurchase }}</strong> </td>
                                </tr>

                                <tr>
                                    <td> @lang('cash_register.emi'):</td>
                                    <td class="display_currency " data-currency_symbol="true"><strong>{{ $emiPurchase }}</strong> </td>
                                </tr>

                                <tr>
                                    <td> @lang('cash_register.mobile_banking'):</td>
                                    <td class="display_currency " data-currency_symbol="true"><strong>{{ $bkashPurchase }}</strong> </td>
                                </tr>

                                <tr>
                                    <td> @lang('cash_register.total_purchase'):</td>
                                    <td class="display_currency success " data-currency_symbol="true"><strong>{{ $purchase+$chequePurchase+$cardPurchase+$balancePurchase+$bankPurchase+$emiPurchase }}</strong> </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">@lang('cash_register.sales_register')</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td> @lang('cash_register.cash_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_cash }} TK</td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.cheque_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_cheque }} TK</td>
                                </tr>
                                <tr>
                                    <td> @lang('cash_register.card_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_card }} TK</td>
                                </tr>
                                <tr>
                                    <td>@lang('cash_register.bank_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_bank_transfer }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('cash_register.emi_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_emi }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('cash_register.mobile_bank_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $register_details->total_bkash }}</td>
                                </tr>

                                <tr>
                                    <td> @lang('cash_register.credit_sale'):</td>
                                    <td class="display_currency" data-currency_symbol="true">{{ $credit }} </td>
                                </tr>

                                <tr>
                                    <td>
                                        @lang('cash_register.total_sales'):
                                    </td>
                                    <td>
                                        <span class="display_currency success" data-currency_symbol="true">{{ $register_details->total_sale + $credit }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">@lang('cash_register.total')</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>@lang('cash_register.total_cash')</td>
                                    <td>@lang('cash_register.total_credit')</td>
                                    {{--<td>Total Due</td>--}}
                                </tr>
                                <tr>
                                    <td>
                                        @php
                                            $total=($register_details->cash_in_hand + $register_details->total_cash+$cashForward) - ($register_details->total_cash_refund+$expenses+$purchase);
                                        @endphp

                                        <b><span class="display_currency" data-currency_symbol="true">{{ $total }}</span></b>
                                    </td>
                                    <td>
                                        <b><span class="display_currency" data-currency_symbol="true">{{ $credit }}</span></b>
                                    </td>

                                    {{--<td>12000 TK</td>--}}
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="col-md-12">
                    @include('cash_register.register_product_details')
                </div>
                <hr>

                <hr>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('closing_amount', __( 'cash_register.total_cash' ) . ':*') !!}
                                {!! Form::text('closing_amount', @num_format($total), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'cash_register.total_cash' ) ]); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('total_card_slips', __( 'cash_register.total_card_slips' ) . ':*') !!} @show_tooltip(__('tooltip.total_card_slips'))
                                {!! Form::number('total_card_slips', $register_details->total_card_slips, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_card_slips' ), 'min' => 0 ]); !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('total_cheques', __( 'cash_register.total_cheques' ) . ':*') !!} @show_tooltip(__('tooltip.total_cheques'))
                                {!! Form::number('total_cheques', $register_details->total_cheques, ['class' => 'form-control', 'required', 'placeholder' => __( 'cash_register.total_cheques' ), 'min' => 0 ]); !!}
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('closing_note', __( 'cash_register.closing_note' ) . ':') !!}
                                {!! Form::textarea('closing_note', null, ['class' => 'form-control', 'placeholder' => __( 'cash_register.closing_note' ), 'rows' => 3 ]); !!}
                            </div>
                        </div>
                    </div>
                </div>
                <hr>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.cancel' )</button>
                <button type="submit" class="btn btn-primary">@lang( 'cash_register.close_register' )</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
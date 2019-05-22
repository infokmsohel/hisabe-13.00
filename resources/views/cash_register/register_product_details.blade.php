<h4 class="text-center topspace">@lang('cash_register.sales_description')</h4>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <table class="table table-responsive text-center" style="border: 1px solid black">

      <tbody class="text-center table-bordered">
      <tr>
        <td>SL.</td>
        <td >@lang('cash_register.sales_particular')</td>
        <td >@lang('sale.qty')</td>
        <td >@lang('brand.brands')</td>
        <td >@lang('cash_register.buy_rate')</td>
        <td >@lang('cash_register.sale_rate')</td>

        <td >@lang('sale.total_amount')</td>
        <td >@lang('cash_register.profit')</td>
      </tr>
      @php
        $total_amount = 0;
        $total_quantity = 0;
      @endphp
      @foreach($details['product_details'] as $detail)
        <tr>
          <td>
            {{$loop->iteration}}.
          </td>
          <td>
            {{$detail->product_name}}
          </td>
          <td>
            {{$detail->total_quantity}}
            @php
              $total_quantity += $detail->total_quantity;
            @endphp
          </td>
          <td>
            {{$detail->brand_name}}
          </td>
          <td>
            {{$detail->purchase_price}}
          </td>
          <td>
            {{$detail->unit_price}}
          </td>

          <td>
            <span class="display_currency" data-currency_symbol="true">
              {{$detail->total_amount}}
            </span>
            @php
              $total_amount += $detail->total_amount;
            @endphp
          </td>
          <td>
            {{ (($detail->unit_price-$detail->purchase_price)/$detail->unit_price)*100 }} %
          </td>
        </tr>
      @endforeach
      @php
        $total_amount += ($details['transaction_details']->total_tax - $details['transaction_details']->total_discount);
      @endphp

      <tr>
        <th>#</th>
        <th></th>
        <th>{{$total_quantity}}</th>
        <th></th>
        <th></th>

        <th></th>
        <th>
          @if($details['transaction_details']->total_tax != 0)
            @lang('sale.order_tax'): (+)
            <span class="display_currency" data-currency_symbol="true">
              {{$details['transaction_details']->total_tax}}
            </span>
            <br/>
          @endif

          @if($details['transaction_details']->total_discount != 0)
            @lang('sale.discount'): (-)
            <span class="display_currency" data-currency_symbol="true">
              {{$details['transaction_details']->total_discount}}
            </span>
            <br/>
          @endif
          @lang('lang_v1.grand_total'):
          <span class="display_currency" data-currency_symbol="true">
            {{$total_amount}}
          </span>
        </th>
      </tr>

      </tbody>
    </table>
  </div>
</div>
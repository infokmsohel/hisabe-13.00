<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!! Form::open(['url' => action('AccountController@store'), 'method' => 'post', 'id' => 'payment_account_form' ]) !!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang( 'account.add_account' )</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __( 'lang_v1.name' ) .":*") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required','placeholder' => __( 'lang_v1.name' ) ]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('account_number', __( 'account.account_number' ) .":*") !!}
                {!! Form::text('account_number', null, ['class' => 'form-control', 'required','placeholder' => __( 'account.account_number' ) ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('account_category', __( 'account.account_category' ) .":") !!}
                {!! Form::select('account_category', $accountCategories, null, ['class' => 'form-control','id' => 'seeAnotherFieldGroup']); !!}
            </div>

            <div class="form-group" id="otherFieldGroupDiv">
                <div class="form-group">

                    <label for="bank_id">@lang( 'account.bank_name' )</label>
                    <select id="bank_id" name="bank_id" class="form-control">
                        <option value="" selected >Select</option>
                        @foreach ($bankList as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    {!! Form::label('new_account_number', __( 'account.account_number' ) .":*") !!}
                    {!! Form::text('new_account_number', null, ['class' => 'form-control','placeholder' => __( 'account.account_number' ) ]); !!}
                </div>

                <h3>Bank Account Branch Information</h3>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputDivision">Division</label>
                        <select id="inputDivision" name="division_id" class="form-control">
                            <option value="" selected >Select</option>
                            @foreach ($divisions as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDistrict">District</label>
                        <select id="inputDistrict" name="district_id" class="form-control">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group" id="otherFieldGroupDiv2">
                <div class="form-group">
                    {!! Form::label('mobile_bank', __( 'account.mobile_bank' ) .":") !!}
                    {!! Form::select('mobile_bank', $mobileBank, null, ['class' => 'form-control']); !!}
                </div>
                <div class="form-group">
                    {!! Form::label('number', __( 'account.mobile_number' ) .":*") !!}
                    {!! Form::text('number', null, ['class' => 'form-control', 'placeholder' => __( 'account.mobile_number' ) ]); !!}
                </div>
            </div>

            <div class="form-group" id="otherFieldGroupDiv3">
                <div class="form-group">
                    {!! Form::label('card_name', __( 'account.card_name' ) .":") !!}
                    {!! Form::text('card_name', null, ['class' => 'form-control', 'placeholder' => __( 'account.card_name' ) ]); !!}
                </div>
                <div class="form-group">
                    {!! Form::label('card_number', __( 'account.card_number' ) .":*") !!}
                    {!! Form::text('card_number', null, ['class' => 'form-control', 'placeholder' => __( 'account.card_number' ) ]); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('new_account_type', __( 'account.new_account_type' ) .":") !!}
                {!! Form::select('new_account_type', $new_account_types, null, ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('opening_balance', __( 'account.opening_balance' ) .":") !!}
                {!! Form::text('opening_balance', 0, ['class' => 'form-control input_number','placeholder' => __( 'account.opening_balance' ) ]); !!}
            </div>
            <div class="form-group">
                {!! Form::label('note', __( 'brand.note' )) !!}
                {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'brand.note' ), 'rows' => 4]); !!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>

        {!! Form::close() !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $("#seeAnotherFieldGroup").change(function() {
        if ($(this).val() == "bank") {
            $('#otherFieldGroupDiv').show();
            $('#otherFieldGroupDiv2').hide();
            $('#otherFieldGroupDiv3').hide();
        } else if ($(this).val() == "Mobile Banking") {
            $('#otherFieldGroupDiv2').show();
            $('#otherFieldGroupDiv').hide();
            $('#otherFieldGroupDiv3').hide();
        }
        else if ($(this).val() == "card") {
            $('#otherFieldGroupDiv3').show();
            $('#otherFieldGroupDiv').hide();
            $('#otherFieldGroupDiv2').hide();
        } else {
            $('#otherFieldGroupDiv').hide();
            $('#otherFieldGroupDiv2').hide();
            $('#otherFieldGroupDiv3').hide();
        }
    });
    $("#seeAnotherFieldGroup").trigger("change");
    $('document').ready(function(){
        $('#inputDivision').change(function(){
            var id = $('#inputDivision').val();
            $.ajax({
                url:'{{url('account/get-district-list')}}',
                type:'get',
                data:{id:id},
                dataType: 'json',
                success:function(data){
                    //console.log(data);
                    $('#inputDistrict').html(data) ;
                }
            });
        });
    });
</script>


















{{--<div class="modal-dialog" role="document">--}}
  {{--<div class="modal-content">--}}

    {{--{!! Form::open(['url' => action('AccountController@store'), 'method' => 'post', 'id' => 'payment_account_form' ]) !!}--}}

    {{--<div class="modal-header">--}}
      {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
      {{--<h4 class="modal-title">@lang( 'account.add_account' )</h4>--}}
    {{--</div>--}}

    {{--<div class="modal-body">--}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('name', __( 'lang_v1.name' ) .":*") !!}--}}
                {{--{!! Form::text('name', null, ['class' => 'form-control', 'required','placeholder' => __( 'lang_v1.name' ) ]); !!}--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('account_number', __( 'account.account_number' ) .":*") !!}--}}
                {{--{!! Form::text('account_number', null, ['class' => 'form-control', 'required','placeholder' => __( 'account.account_number' ) ]); !!}--}}
            {{--</div>--}}

            {{----}}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('account_type', __( 'account.account_type' ) .":") !!}--}}
                {{--{!! Form::select('account_type', $account_types, null, ['class' => 'form-control']); !!}--}}
            {{--</div>--}}
            {{----}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('opening_balance', __( 'account.opening_balance' ) .":") !!}--}}
                {{--{!! Form::text('opening_balance', 0, ['class' => 'form-control input_number','placeholder' => __( 'account.opening_balance' ) ]); !!}--}}
            {{--</div>--}}


            {{--<div class="form-group">--}}
                {{--{!! Form::label('note', __( 'brand.note' )) !!}--}}
                {{--{!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'brand.note' ), 'rows' => 4]); !!}--}}
            {{--</div>--}}
    {{--</div>--}}

    {{--<div class="modal-footer">--}}
      {{--<button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>--}}
      {{--<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>--}}
    {{--</div>--}}

    {{--{!! Form::close() !!}--}}

  {{--</div><!-- /.modal-content -->--}}
{{--</div><!-- /.modal-dialog -->--}}
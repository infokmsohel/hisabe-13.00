<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('WarrantyController@update',$warranty->id), 'method' => 'PUT', 'id' => 'edit_payment_account_form' ]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang( 'lang_v1.update_warranty' )</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-map-marker"></i>
									</span>
                            {!! Form::label('warranty_period', __('lang_v1.warranty_period') . ':' ) !!}
                            <input type="text" name="warranty_period" value="{{ $warranty->warranty_period }}" class = 'form-control input-sm mousetrap'>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="margin-bottom: 0px;">
                        <div class="form-group">
                            {!! Form::label('warranty_type', __('lang_v1.select_warranty') . ':' ) !!}
                            <select class=" form-control" id="warranty_type" name="warranty_type" class="form-control" required>
                                <option value="" selected >Warranty time</option>
                                <option value="days">Days</option>
                                <option value="month">Month</option>
                                <option value="years">Years</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<!-- Modal -->
<div class="modal fade" id="add_custom_field_name" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{__('account.add_custom_field')}}</h4>
        </div>
        {!! Form::open(['url'=>'product/add-custom-field','method'=>'post']) !!}
        <div class="modal-body">
            <div class="form-group">
                <label>{{__('account.custom_field_name')}}</label>
                <input type="text" name="fieldName" class="form-control" required placeholder="{{__('account.custom_field_name')}}">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('account.close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('account.add')}} </button>
        </div>
        {!! Form::close()!!}
    </div>
  </div>
</div>
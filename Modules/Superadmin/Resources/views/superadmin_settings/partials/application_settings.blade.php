<div class="pos-tab-content">
    <div class="row">
    	<div class="col-xs-4">
            <div class="form-group">
            	{!! Form::label('APP_NAME', __('superadmin::lang.app_name') . ':') !!}
            	{!! Form::text('APP_NAME', $default_values['APP_NAME'], ['class' => 'form-control','placeholder' => __('superadmin::lang.app_name')]); !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
            	{!! Form::label('APP_TITLE', __('superadmin::lang.app_title') . ':') !!}
            	{!! Form::text('APP_TITLE', $default_values['APP_TITLE'], ['class' => 'form-control','placeholder' => __('superadmin::lang.app_title')]); !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
            	{!! Form::label('APP_LOCALE', __('superadmin::lang.app_default_language') . ':') !!}
            	{!! Form::select('APP_LOCALE', $languages, $default_values['APP_LOCALE'], ['class' => 'form-control']); !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                    {!! Form::checkbox('superadmin_enable_register_tc', 1,!empty($settings["superadmin_enable_register_tc"]), 
                    [ 'class' => 'input-icheck']); !!}
                    @lang('superadmin::lang.enable_register_tc')
                    </label>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('superadmin_register_tc', __('superadmin::lang.register_tc') .":") !!}

                {!! Form::textarea('superadmin_register_tc', !empty($settings['superadmin_register_tc']) ? $settings['superadmin_register_tc'] : '', ['class' => 'form-control', 'rows' => 5, 'cols' => 200]) !!}
            </div>
        </div>
    </div>
</div>
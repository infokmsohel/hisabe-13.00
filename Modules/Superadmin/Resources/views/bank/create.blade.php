@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | Business')
@section('content')
    <section class="content-header">
        <h1>@lang( 'account.bank_name' )
            <small>@lang( 'account.bank_name_add_here' )</small>
        </h1>
    </section>
    <section class="content">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => action('\Modules\Superadmin\Http\Controllers\BankListController@store'), 'method' => 'post',  ]) !!}

                <div class="modal-header">
                    <h4 class="modal-title">@lang( 'account.account_update' )</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('bank_name', __( 'category.bank_name' ) . ':*') !!}
                        {!! Form::text('bank_name',null, ['class' => 'form-control','required', 'placeholder' => __( 'category.bank_name' )]); !!}
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang( 'account.save' )</button>
                        <a class="btn btn-success " href="{{ action('\Modules\Superadmin\Http\Controllers\BankListController@index') }}">Back</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
    </section>
@endsection




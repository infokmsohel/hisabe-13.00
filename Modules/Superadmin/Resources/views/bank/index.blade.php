@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | Business')
@section('content')
    <section class="content-header">
        <h1>@lang( 'account.manage_bank_list' )
            <small>@lang( 'account.manage_bank_list' )</small>
        </h1>

        @if(session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang( 'account.manage_bank_list' )</h3>
                <div class="box-tools">
                    <a class="btn btn-block btn-primary " href="{{ action('\Modules\Superadmin\Http\Controllers\BankListController@create') }}"><i class="fa fa-plus"></i> @lang( 'messages.add' )</a></div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Bank Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $i=1
                            @endphp
                            @foreach($banks as $bank)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $bank->bank_name }}</td>
                                <td>
                                    <a class="btn btn success" href="{{ action('\Modules\Superadmin\Http\Controllers\BankListController@edit',$bank->id) }}">Edit</a>
                                    <a class="btn btn success" href="{{ action('\Modules\Superadmin\Http\Controllers\BankListController@destroy',$bank->id) }}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <div class="modal fade category_modal" tabindex="-1" role="dialog"
             aria-labelledby="gridSystemModalLabel">
        </div>
    </section>
    <!-- /.content -->
@endsection






















{{--@extends('layouts.app')--}}
{{--@section('title', __('superadmin::lang.superadmin') . ' | Business')--}}
{{--@section('content')--}}
    {{--<form action="{{ action('\Modules\Superadmin\Http\Controllers\BankListController@store') }}" method="post" class="form-horizontal col-sm-6 align-content-center">--}}
        {{--{{ csrf_field() }}--}}
        {{--<div class="form-group">--}}
            {{--<label for="name">Bank Name</label>--}}
            {{--<input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name Input  Here">--}}
        {{--</div>--}}
        {{--<button type="submit" name="btn" class="btn btn-primary">Add</button>--}}
    {{--</form>--}}

    {{--<table class="table">--}}
        {{--<thead>--}}
        {{--<tr>--}}
            {{--<th scope="col">#</th>--}}
            {{--<th scope="col">Bank Name</th>--}}
            {{--<th scope="col">Branch</th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}

        {{--<tr>--}}
            {{--<th scope="row">1</th>--}}
            {{--<td>Mark</td>--}}
            {{--<td>Otto</td>--}}
            {{--<td>@mdo</td>--}}
        {{--</tr>--}}

        {{--</tbody>--}}
    {{--</table>--}}
{{--@endsection--}}



{{--@section('javascript')--}}

    {{--<script type="text/javascript">--}}

    {{--</script>--}}

{{--@endsection--}}
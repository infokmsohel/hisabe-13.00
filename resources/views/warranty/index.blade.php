@extends('layouts.app')
@section('title', __('lang_v1.manage_warranty'))
@section('content')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v='.$asset_v) }}">
    <section class="content-header">
        <h1>@lang('lang_v1.manage_warranty')
            <small>@lang('lang_v1.manage_warranty')</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
                <div class="col-sm-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#other_accounts" data-toggle="tab">
                                    <i class="fa fa-book"></i> <strong>@lang('lang_v1.manage_warranty')</strong>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="other_accounts">
                                <table class="table table-bordered table-striped" id="warranty_table">
                                    <thead>
                                    <tr>
                                        <th>@lang( 'lang_v1.warranty_id' )</th>
                                        <th>@lang( 'lang_v1.sale_date' )</th>
                                        <th>@lang( 'lang_v1.serial_id' )</th>
                                        <th>@lang('lang_v1.product_name')</th>
                                        <th>@lang('lang_v1.warranty_type')</th>
                                        <th>@lang('lang_v1.warranty_period')</th>
                                        <th>@lang( 'lang_v1.action' )</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal fade account_model" tabindex="-1" role="dialog"
             aria-labelledby="gridSystemModalLabel">
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('javascript')
    <script src="{{ asset('plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js?v=' . $asset_v) }}"></script>
    <script>
        $(function(){
                $('#warranty_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! url()->current() !!}',
                    columns: [
                        { data: 'warranty_id', name: 'warranty_id' },
                        { data: 'sale_date', name: 'sale_date','orderable': false},
                        { data: 'serial_id', name:'serial_id','orderable': false},
                        { data: 'product_name', name: 'product_name','orderable': false},
                        { data: 'warranty_type', name: 'warranty_type','orderable': false},
                        { data: 'warranty_period', name: 'warranty_period','orderable': false},
                    ],
                    "lengthMenu": [[50, 100, 500,1000, -1], [50, 100, 500,1000, "All"]],
                });
            });
            function printN(id){
                $('#'+id).printThis();
            }

    </script>
@endsection
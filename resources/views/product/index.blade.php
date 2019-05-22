@extends('layouts.app')
@section('title', __('sale.products'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('sale.products')
        <small>@lang('lang_v1.manage_products')</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
@component('components.filters', ['title' => __('report.filters')])
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('type', __('product.product_type') . ':') !!}
            {!! Form::select('type', ['single' => 'Single', 'variable' => 'Variable'], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_type', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('category_id', __('product.category') . ':') !!}
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_category_id', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('unit_id', __('product.unit') . ':') !!}
            {!! Form::select('unit_id', $units, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_unit_id', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('tax_id', __('product.tax') . ':') !!}
            {!! Form::select('tax_id', $taxes, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_tax_id', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('brand_id', __('product.brand') . ':') !!}
            {!! Form::select('brand_id', $brands, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_brand_id', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>
@endcomponent

@component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.all_products')])
    @can('product.create')
        @slot('tool')
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('ProductController@create')}}">
                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
            </div>
        @endslot
    @endcan
    @can('product.view')
        <div class="table-responsive">
            <table class="table table-bordered table-striped ajax_view table-text-center" id="product_table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-row"></th>
                        <th>&nbsp;</th>
                        <th>@lang('sale.product')</th>
                        <th>@lang('product.product_type')</th>
                        <th>@lang('product.category')</th>
                        <th>@lang('product.sub_category')</th>
                        <th>@lang('product.unit')</th>
                        <th>@lang('product.brand')</th>
                        <th>@lang('product.tax')</th>
                        <th>@lang('product.sku')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="11">
                        <div style="display: flex; width: 100%;">
                            @can('product.delete')
                                {!! Form::open(['url' => action('ProductController@massDestroy'), 'method' => 'post', 'id' => 'mass_delete_form' ]) !!}
                                {!! Form::hidden('selected_rows', null, ['id' => 'selected_rows']); !!}
                                {!! Form::submit(__('lang_v1.delete_selected'), array('class' => 'btn btn-xs btn-danger', 'id' => 'delete-selected')) !!}
                                {!! Form::close() !!}
                            @endcan
                            &nbsp;
                            {!! Form::open(['url' => action('ProductController@massDeactivate'), 'method' => 'post', 'id' => 'mass_deactivate_form' ]) !!}
                            {!! Form::hidden('selected_products', null, ['id' => 'selected_products']); !!}
                            {!! Form::submit(__('lang_v1.deactivate_selected'), array('class' => 'btn btn-xs btn-warning', 'id' => 'deactivate-selected')) !!}
                            {!! Form::close() !!} @show_tooltip(__('lang_v1.deactive_product_tooltip'))
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endcan
@endcomponent
    <input type="hidden" id="is_rack_enabled" value="{{$rack_enabled}}">

    <div class="modal fade product_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade" id="view_product_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade" id="opening_stock_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        $(document).ready( function(){
            var product_table = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "/products",
                    "data": function ( d ) {
                        d.type = $('#product_list_filter_type').val();
                        d.category_id = $('#product_list_filter_category_id').val();
                        d.brand_id = $('#product_list_filter_brand_id').val();
                        d.unit_id = $('#product_list_filter_unit_id').val();
                        d.tax_id = $('#product_list_filter_tax_id').val();
                    }
                },
                columnDefs: [ {
                    "targets": [0, 1, 10],
                    "orderable": false,
                    "searchable": false
                } ],
                aaSorting: [2, 'asc'],
                columns: [
                        { data: 'mass_delete'  },
                        { data: 'image', name: 'products.image'  },
                        { data: 'product', name: 'products.name'  },
                        { data: 'type', name: 'products.type'},
                        { data: 'category', name: 'c1.name'},
                        { data: 'sub_category', name: 'c2.name'},
                        { data: 'unit', name: 'units.actual_name'},
                        { data: 'brand', name: 'brands.name'},
                        { data: 'tax', name: 'tax_rates.name'},
                        { data: 'sku', name: 'products.sku'},
                        { data: 'action', name: 'action'}
                    ],
                    createdRow: function( row, data, dataIndex ) {
                        if($('input#is_rack_enabled').val() == 1){
                            var target_col = 0;
                            @can('product.delete')
                                target_col = 1;
                            @endcan
                            $( row ).find('td:eq('+target_col+') div').prepend('<i style="margin:auto;" class="fa fa-plus-circle text-success cursor-pointer no-print rack-details" title="' + LANG.details + '"></i>&nbsp;&nbsp;');
                        }
                        $( row ).find('td:eq(0)').attr('class', 'selectable_td');
                    }
            });
            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#product_table tbody').on( 'click', 'tr i.rack-details', function () {
                var i = $(this);
                var tr = $(this).closest('tr');
                var row = product_table.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    i.addClass( 'fa-plus-circle text-success' );
                    i.removeClass( 'fa-minus-circle text-danger' );

                    row.child.hide();
         
                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                } else {
                    i.removeClass( 'fa-plus-circle text-success' );
                    i.addClass( 'fa-minus-circle text-danger' );

                    row.child( get_product_details( row.data() ) ).show();
         
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            });

            $('table#product_table tbody').on('click', 'a.delete-product', function(e){
                e.preventDefault();
                swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    product_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#delete-selected', function(e){
                e.preventDefault();
                var selected_rows = [];
                var i = 0;
                $('.row-select:checked').each(function () {
                    selected_rows[i++] = $(this).val();
                }); 
                
                if(selected_rows.length > 0){
                    $('input#selected_rows').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_delete_form').submit();
                        }
                    });
                } else{
                    $('input#selected_rows').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });

            $(document).on('click', '#deactivate-selected', function(e){
                e.preventDefault();
                var selected_rows = [];
                var i = 0;
                $('.row-select:checked').each(function () {
                    selected_rows[i++] = $(this).val();
                }); 
                
                if(selected_rows.length > 0){
                    $('input#selected_products').val(selected_rows);
                    swal({
                        title: LANG.sure,
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('form#mass_deactivate_form').submit();
                        }
                    });
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            })

            $('table#product_table tbody').on('click', 'a.activate-product', function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                $.ajax({
                    method: "get",
                    url: href,
                    dataType: "json",
                    success: function(result){
                        if(result.success == true){
                            toastr.success(result.msg);
                            product_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            });

            $(document).on('change', '#product_list_filter_type, #product_list_filter_category_id, #product_list_filter_brand_id, #product_list_filter_unit_id, #product_list_filter_tax_id', 
                function() {
                    product_table.ajax.reload();
            });
        });

        $(document).on('shown.bs.modal', 'div.view_product_modal, div.view_modal', function(){
            __currency_convert_recursively($(this));
        });
    </script>
@endsection
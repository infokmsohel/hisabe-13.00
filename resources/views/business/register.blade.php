@extends('layouts.auth')
@section('title', __('lang_v1.register'))
@section('content')
<div class="container-fluid ">
    <div class="row flex-row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 hidden-xs hidden-sm reg-bg">
            
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="background:#eee;">
                    <div class="box box-solid">
                        <div class="text-center">
                            <center>
                                <img src="{{asset('logo/logo.png')}}" class="img-responsive" width="200">
                            </center>
                        </div>
                        @if(Session::has('message'))
                        <div class="alert alert-danger">
                            {{ Session::get('message')}}
                        </div>
                        @endif
                        <div class="box-header with-border">
                            <h3 class="box-title text-center">@lang('business.register_and_get_started_in_minutes')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['url' => route('business.postRegister'), 'method' => 'post', 
                            'id' => 'business_register_form','files' => true ]) !!}
                                @include('business.partials.register_form')
                                {!! Form::hidden('package_id', $package_id); !!}
                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
        </div>
    </div>
            <!-- End Row -->
</div>

@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('business.getRegister') }}?lang=" + $(this).val();
        });
    })
</script>
<script>
    $('document').ready(function(){
        $('#business_type_id').change(function(){
            var id = $('#business_type_id').val();

            $.ajax({
                url:'{{url('/business/register/sub-type')}}',
                type:'get',
                data:{id:id},
                dataType: 'json',
                success:function(data){
                    //console.log(data);
                    $('#sub_type_id').html(data) ;
                }
            });
        });
    });
</script>
@endsection
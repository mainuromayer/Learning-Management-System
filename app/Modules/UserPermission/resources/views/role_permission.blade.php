@extends('layouts.admin')

@section('header-resources')
@include('partials.datatable_css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 pt-3">
        <div class="card card-outline card-primary p-5">

            <div class="card-header">
                <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Module and Feature Permission</h3>
                <div class="card-tools">
                </div>
            </div>
            {!! Form::open([
            'route' => 'user-permission.store',
            'method' => 'post',
            'id' => 'form_id',
            'enctype' => 'multipart/form-data',
            'files' => 'true',
            'role' => 'form',
            ]) !!}
            <div class="card-body ">
                <div class="pt-3">
                    <div class=" pb-3 pt-3 input-group row {{$errors->has('user_type') ? 'has-error' : ''}}">
                        {!! Form::label('role_id','User Type:',['class'=>'col-md-2 control-label required-star']) !!}
                        <div class="col-md-10">
                            {!! Form::select('role_id', $roles, old('role_id'), ['class' => 'form-control required user_role', 'change'=>'load_module_permission()']) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center p-5 spinner">
                        <div class="loader">
                        </div>
                    </div>
                    <div class="module-permission-content">
                    </div>
                </div>
            </div>
            {!! form::close() !!}
        </div><!-- /.panel -->
    </div>
</div>
@endsection

@section('footer-script')


<script>
    $(document).ready(function() {
        // $('.user_role').val('1')
        $('.user_role').trigger('change')
    });

    $('.user_role').change(function() {
        $('.module-permission-content').hide()
        $('.spinner').show();
        var user_role = $('.user_role').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "post",
            url: "{{ route('module_permission') }}",
            data: {
                _token: _token,
                role: user_role
            },
            success: function(response) {
                $('.spinner').hide();
                $('.module-permission-content').html(response)
                $('.module-permission-content').show()
            }
        });
    });
</script>
@endsection
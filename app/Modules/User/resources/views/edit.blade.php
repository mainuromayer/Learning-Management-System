@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

@endsection
@section('content')
    {!! Form::open([
        'route' => 'user.store',
        'method' => 'post',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => 'true',
        'role' => 'form',
    ]) !!}
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Update User</h3>
                    <div class="card-tools">
                        <a href="{{ route('user.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> User List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    {!! Form::hidden('id', $data->id) !!}
                    <!-- Email -->
                    <div class="input-group row {{$errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email','Email:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('email', $data->email, ['class' => 'form-control required','id' => 'email', 'readonly' => 'true']) !!}
                            {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="input-group row {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name','User Name:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', $data->name, ['class' => 'form-control required']) !!}
                            {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- User Type -->
                    <div class="input-group row {{$errors->has('user_type') ? 'has-error' : ''}}">
                        {!! Form::label('role','User Type:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('role', $roles, $data->role_id, ['class' => 'form-control user_type']) !!}
                            {!! $errors->first('role', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Update Button -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Update', [
                                'type' => 'submit',
                                'class' => 'btn btn-primary'
                            ]) !!}
                        </div>
                    </div>

                </div>

                {!! form::close() !!}

            </div>

        </div>
    </div>
@endsection

@section('footer-script')

    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });


        });
    </script>
@endsection

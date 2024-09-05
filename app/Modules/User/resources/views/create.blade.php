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
                    <h3 class="card-title pt-2 pb-2"> Create New User </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.list') }}" class="btn btn-sm btn-primary"><i
                                class="bx bx-list-ul pr-2"></i> User List </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">
                    <!-- Email -->
                    <div class="input-group row {{$errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email','Email:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('email', old('email'), ['class' => 'form-control required','id' => 'email', 'readonly' => 'true']) !!}
                            {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- User Name -->
                    <div class="input-group row {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name','User Name:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name'), ['class' => 'form-control required']) !!}
                            {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-group row {{$errors->has('password') ? 'has-error' : ''}}">
                        {!! Form::label('password','Password:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', ['class' => 'form-control required']) !!}
                            {!! $errors->first('password','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- User Type -->
                    <div class="input-group row {{$errors->has('user_type') ? 'has-error' : ''}}">
                        {!! Form::label('role','User Type:',['class'=>'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('role', $roles, old('role'), ['class' => 'form-control required user_type']) !!}
                            {!! $errors->first('role', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Add and Reset Buttons -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Add', [
                                'type' => 'submit',
                                'class' => 'btn btn-primary'
                            ]) !!}
                            {!! Form::button('Reset', [
                                'type' => 'button',
                                'class' => 'btn btn-secondary',
                                'id' => 'reset_button'
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
        $(function() {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });


            // Reset form fields when Reset button is clicked
            $('#reset_button').click(function() {
                $('#form_id')[0].reset(); // Reset all form fields
                $('.select2').val(null).trigger('change'); // Reset select2 fields
            });

        });
    </script>
@endsection

@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    {!! Form::open([
        'route' => 'instructor.store',
        'method' => 'post',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => true,
        'role' => 'form',
    ]) !!}

    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Instructor Basic Info</h3>
                    <div class="card-tools">
                        <a href="{{ route('instructor.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Instructor List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Instructor Name -->
                    <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Name'
                            ]) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="form-group row {{ $errors->has('biography') ? 'has-error' : '' }}">
                        {!! Form::label('biography', 'Biography:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('biography', old('biography'), [
                                'class' => 'form-control',
                                'placeholder' => 'Biography'
                            ]) !!}
                            {!! $errors->first('biography', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="form-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Phone:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone', old('phone'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Phone'
                            ]) !!}
                            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'Address:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('address', old('address'), [
                                'class' => 'form-control',
                                'placeholder' => 'Address'
                            ]) !!}
                            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- User Image -->
                    <div class="form-group row {{ $errors->has('user_image') ? 'has-error' : '' }}">
                        {!! Form::label('user_image', 'User Image:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <img id="newUserImage" src="{{ asset('images/no_image.png') }}" style="height:120px;" />
                            {!! Form::file('user_image', [
                                'class' => 'form-control mt-3',
                                'id' => 'user_image',
                                'onchange' => "document.getElementById('newUserImage').src=window.URL.createObjectURL(this.files[0])",
                            ]) !!}
                            {!! $errors->first('user_image', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Login Credentials</h3>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Email -->
                    <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('email', old('email'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Email'
                            ]) !!}
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Password:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', [
                                'class' => 'form-control required',
                                'placeholder' => 'Password'
                            ]) !!}
                                   {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                 </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Social Links</h3>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Facebook -->
                    <div class="form-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        {!! Form::label('facebook', 'Facebook:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('facebook', old('facebook'), [
                                'class' => 'form-control',
                                'placeholder' => 'Facebook'
                            ]) !!}
                            {!! $errors->first('facebook', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Twitter -->
                    <div class="form-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        {!! Form::label('twitter', 'Twitter:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('twitter', old('twitter'), [
                                'class' => 'form-control',
                                'placeholder' => 'Twitter'
                            ]) !!}
                            {!! $errors->first('twitter', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Linkedin -->
                    <div class="form-group row {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                        {!! Form::label('linkedin', 'Linkedin:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('linkedin', old('linkedin'), [
                                'class' => 'form-control',
                                'placeholder' => 'Linkedin'
                            ]) !!}
                            {!! $errors->first('linkedin', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                                        <!-- Status -->
                                        <div class="input-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                                            {!! Form::label('status', 'Status: ', ['class' => 'col-md-3 control-label  required-star']) !!}
                                            <div class="col-md-9">
                                                {!! Form::select('status', $status_list, old('status'), [
                                                    'class' => 'form-control select2 categories required',
                                                ]) !!}
                                                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
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

            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('footer-script')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Enter Keywords',
                allowClear: true
            });

            // Reset form fields when Reset button is clicked
            $('#reset_button').click(function() {
                $('#form_id')[0].reset(); // Reset all form fields
                $('.select2').val(null).trigger('change'); // Reset select2 fields
                $('#newUserImage').attr('src', '{{ asset('images/no_image.png') }}'); // Reset image preview
            });
        });
    </script>
@endsection

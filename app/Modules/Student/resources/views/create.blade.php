@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')

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
        'route' => 'student.store',
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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Student Basic Info </h3>
                    <div class="card-tools">
                        <a href="{{ route('student.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Student List
                        </a>
                    </div>
                </div>


                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                   
                    <div class="input-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter name ',
                            ]) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('biography') ? 'has-error' : '' }}">
                        {!! Form::label('biography', 'Biography', ['class' => 'col-md-3 control-label ']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('biography', old('biography'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter biography',
                            ]) !!}
                            {!! $errors->first('biography', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="input-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'phone', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone', old('phone'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter phone',
                            ]) !!}
                            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="input-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'address', ['class' => 'col-md-3 control-label ']) !!}
                        <div class="col-md-9">
                            {!! Form::text('address', old('address'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter address',
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

            <div class="card card-outline card-primary form-card mt-3">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Student Login Info</h3>
                    
                </div> 

                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                   
                    <div class="input-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::email('email', old('email'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter email ',
                            ]) !!}
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
 
                    <div class="input-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Password', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter password',
                            ]) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                </div>
                

               
            </div>
            
            <div class="card card-outline card-primary form-card mt-3">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Student Social Media Info</h3>
                    
                </div> 

                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                   
                    <div class="input-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        {!! Form::label('facebook', 'Facebook', ['class' => 'col-md-3 control-label ']) !!}
                        <div class="col-md-9">
                            {!! Form::text('facebook', old('facebook'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter facebook ',
                            ]) !!}
                            {!! $errors->first('facebook', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="input-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        {!! Form::label('twitter', 'Twitter', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('twitter', old('twitter'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter twitter ',
                            ]) !!}
                            {!! $errors->first('twitter', '<span class="help-block">:message</span>') !!}
                        </div> 
                    </div>
                    <div class="input-group row {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                        {!! Form::label('linkedin', 'Linkedin', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('linkedin', old('linkedin'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter linkedin ',
                            ]) !!}
                            {!! $errors->first('linkedin', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div> 
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


            {!! form::close() !!}
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>

      
        $(document).ready(function() {
        
        $('.select2').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Enter Keywords',
                allowClear: true
            });

            $('#reset_button').click(function() {
            $('#form_id')[0].reset(); // Reset all form fields
            $('.select2').val(null).trigger('change'); // Reset select2 fields
            $('#newUserImage').attr('src', '{{ asset('images/no_image.png') }}'); // Reset image preview
         
        });
    });
    </script>
@endsection

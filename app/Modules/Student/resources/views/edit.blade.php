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
        'route' => 'student.store',
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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Edit Student</h3>
                   
                </div>


                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="input-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', 'name', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('name', $data->name, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter name ',
                            ]) !!}
                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    <div class="input-group row {{ $errors->has('biography') ? 'has-error' : '' }}">
                        {!! Form::label('biography', 'short description', ['class' => 'col-md-3 control-label ']) !!}
                        <div class="col-md-9">
                            {!! Form::text('biography', $data->biography, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter biography ',
                            ]) !!}
                            {!! $errors->first('biography', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    
                    <div class="input-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'phone', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone', $data->phone, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter phone ',
                            ]) !!}
                            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    <div class="input-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'address', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('address', $data->address, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter address ',
                            ]) !!}
                            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    <div class="input-group row {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', 'image', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('image', $data->image, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter image ',
                            ]) !!}
                            {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  


                    <div class="input-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::email('email', old('email', $data->email), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter email',
                            ]) !!}
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="input-group row {{ $errors->has('password') ? 'has-error' : '' }}">
                        {!! Form::label('password', 'Password', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::password('password', [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter new password (leave blank if not changing)',
                            ]) !!}
                            @if ($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="input-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        {!! Form::label('facebook', 'Facebook', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('facebook', old('facebook', $data->facebook), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Facebook profile link',
                            ]) !!}
                            {!! $errors->first('facebook', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="input-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        {!! Form::label('twitter', 'Twitter', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('twitter', old('twitter', $data->twitter), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Twitter profile link',
                            ]) !!}
                            {!! $errors->first('twitter', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    
                    <div class="input-group row {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                        {!! Form::label('linkedin', 'LinkedIn', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('linkedin', old('linkedin', $data->linkedin), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter LinkedIn profile link',
                            ]) !!}
                            {!! $errors->first('linkedin', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    
                   
                    <div class="input-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Update</button>
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
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $(function() {
            $(".select2").select2();

        });
    </script>
@endsection

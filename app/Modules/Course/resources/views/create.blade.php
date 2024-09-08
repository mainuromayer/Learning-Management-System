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
        'route' => 'course.store',
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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Create New Course</h3>
                    
                </div>


                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                   
                    <div class="input-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', old('title'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter title ',
                            ]) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('short_description') ? 'has-error' : '' }}">
                        {!! Form::label('short_description', 'short Description', ['class' => 'col-md-3 control-label ']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('short_description', old('short_description'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Short Description',
                            ]) !!}
                            {!! $errors->first('short_description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Description',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('create_as') ? 'has-error' : '' }}">
                        {!! Form::label('create_as', 'create as ?', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('create_as', 0, null,['class' => 'required','checked']) !!} Active</label>
                            <label>{!! Form::radio('create_as', 1, null,['class' => 'required']) !!} Inactive</label> 
                            <label>{!! Form::radio('create_as', 2, null,['class' => 'required']) !!} Privite</label> 
                            <label>{!! Form::radio('create_as', 3, null,['class' => 'required']) !!} Upcoming</label> 
                            <label>{!! Form::radio('create_as', 4, null,['class' => 'required']) !!} Pending</label> 
                            <label>{!! Form::radio('create_as', 5, null,['class' => 'required']) !!} Draft</label> 
                        </div>
                    </div>
{{-- 
                    <div class="input-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'category', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('category', old('category'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter category',
                            ]) !!}
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div> --}}

                    <div class="input-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'category', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('category', 
                                ['html' => 'HTML', 'laravel' => 'Laravel', 'python' => 'Python'], // options array
                                old('category'), // selected value
                                ['class' => 'form-control select2 required', 'placeholder' => 'Select catagory level'] // additional attributes
                            ) !!}
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="input-group row {{ $errors->has('course_level') ? 'has-error' : '' }}">
                        {!! Form::label('course_level', 'Course Level', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('course_level', 
                                ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'], // options array
                                old('course_level'), // selected value
                                ['class' => 'form-control select2 required', 'placeholder' => 'Select course level'] // additional attributes
                            ) !!}
                            {!! $errors->first('course_level', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    

                    {{-- <div class="input-group row {{ $errors->has('course_level') ? 'has-error' : '' }}">
                        {!! Form::label('course_level', 'course level', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('course_level', old('course_level'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter course level',
                            ]) !!}
                            {!! $errors->first('course_level', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div> --}}

                    
                    <div class="form-group row {{ $errors->has('pricing_type') ? 'has-error' : '' }}">
                        {!! Form::label('pricing_type', 'pricing type?', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('pricing_type', 0, null,['class' => 'required','checked']) !!} Free</label>
                            <label>{!! Form::radio('pricing_type', 1, null,['class' => 'required']) !!} Paid</label> 
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Price', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::number('price', old('price'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter price',
                                'step' => '0.01', // Allows decimal values (for prices)
                                'min' => '0' // Optional: Prevents negative values
                            ]) !!}
                            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    

                    {{-- <div class="input-group row {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'price ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('price', old('price'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter  price',
                            ]) !!}
                            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div> --}}

                   
                    <div class="input-group row {{ $errors->has('discounted_price') ? 'has-error' : '' }}">
                        {!! Form::label('discounted_price', 'discounted price', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::number('discounted_price', old('discounted_price'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter discounted price',
                                'step' => '0.01', // Allows decimal values (for prices)
                                'min' => '0' // Optional: Prevents negative values
                            ]) !!}
                            {!! $errors->first('discounted_price', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
                        {!! Form::label('thumbnail', 'Thumbnail ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('thumbnail', old('thumbnail'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter thumbnail',
                            ]) !!}
                            {!! $errors->first('thumbnail', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    {{-- <div class="input-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div> --}}
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
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
         $('#reset_button').click(function() {
            $('#form_id')[0].reset(); // Reset all form fields
            $('.select2').val(null).trigger('change'); // Reset select2 fields
        });
        $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Choose Your Course Area',
            allowClear: true
        });
    });
    </script>
@endsection

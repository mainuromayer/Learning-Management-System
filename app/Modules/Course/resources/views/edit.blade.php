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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Edit Course</h3>
                   
                </div>


                <!-- /.card-header -->
                <div class="card-body demo-vertical-spacing">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    
                    {{-- <div class="input-group row {{ $errors->has('zone_name') ? 'has-error' : '' }}">
                        {!! Form::label('zone_name', 'Zone', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            @php
                                 $subzones = $subzones ?? [];
                            @endphp
                            {!! Form::select('zone_name[]', $subzones, old('zone_name'), [
                                'class' => 'form-control required select2',
                                'single' => 'single',
                                'placeholder' => 'Choose Your Zone Area',
                            ]) !!}
                            {!! $errors->first('zone_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div> --}}

                    <div class="input-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', $data->title, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter title ',
                            ]) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    <div class="input-group row {{ $errors->has('short_description') ? 'has-error' : '' }}">
                        {!! Form::label('short_description', 'short description', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('short_description', $data->short_description, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter short description ',
                            ]) !!}
                            {!! $errors->first('short_description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    
                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('description', $data->description, [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter description ',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>  
                    <div class="form-group row {{ $errors->has('create_as') ? 'has-error' : '' }}">
                        {!! Form::label('create_as', 'Create as?', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('create_as', 0, old('create_as') == 0 || isset($model) && $model->create_as == 0, ['class' => 'required']) !!} Active</label>
                            <label>{!! Form::radio('create_as', 1, old('create_as') == 1 || isset($model) && $model->create_as == 1, ['class' => 'required']) !!} Inactive</label>
                            <label>{!! Form::radio('create_as', 2, old('create_as') == 2 || isset($model) && $model->create_as == 2, ['class' => 'required']) !!} Private</label>
                            <label>{!! Form::radio('create_as', 3, old('create_as') == 3 || isset($model) && $model->create_as == 3, ['class' => 'required']) !!} Upcoming</label>
                            <label>{!! Form::radio('create_as', 4, old('create_as') == 4 || isset($model) && $model->create_as == 4, ['class' => 'required']) !!} Pending</label>
                            <label>{!! Form::radio('create_as', 5, old('create_as') == 5 || isset($model) && $model->create_as == 5, ['class' => 'required']) !!} Draft</label>
                        </div>
                    </div>
                    <div class="input-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'Category', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('category', 
                                ['html' => 'HTML', 'laravel' => 'Laravel', 'python' => 'Python'], // options array
                                old('category', $data->category), // selected value from $data->category
                                ['class' => 'form-control select2 required', 'placeholder' => 'Select category'] // additional attributes
                            ) !!}
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('course_level') ? 'has-error' : '' }}">
                        {!! Form::label('course_level', 'Course Level', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('course_level', 
                                ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'], // options array
                                old('course_level', $data->course_level), // selected value from $data->course_level
                                ['class' => 'form-control select2 required', 'placeholder' => 'Select course level'] // additional attributes
                            ) !!}
                            {!! $errors->first('course_level', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('pricing_type') ? 'has-error' : '' }}">
                        {!! Form::label('pricing_type', 'Pricing Type?', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('pricing_type', 0, old('pricing_type', $data->pricing_type) == 0, ['class' => 'required']) !!} Free</label>
                            <label>{!! Form::radio('pricing_type', 1, old('pricing_type', $data->pricing_type) == 1, ['class' => 'required']) !!} Paid</label> 
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Price', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::number('price', old('price', $data->price), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter price',
                                'step' => '0.01', // Allows decimal values (for prices)
                                'min' => '0' // Optional: Prevents negative values
                            ]) !!}
                            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('discounted_price') ? 'has-error' : '' }}">
                        {!! Form::label('discounted_price', 'Discounted Price', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::number('discounted_price', old('discounted_price', $data->discounted_price), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter discounted price',
                                'step' => '0.01', // Allows decimal values (for prices)
                                'min' => '0' // Optional: Prevents negative values
                            ]) !!}
                            {!! $errors->first('discounted_price', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
                        {!! Form::label('thumbnail', 'Thumbnail', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('thumbnail', old('thumbnail', $data->thumbnail), [
                                'class' => 'form-control required',
                                'placeholder' => 'Enter thumbnail URL or path',
                            ]) !!}
                            {!! $errors->first('thumbnail', '<span class="help-block">:message</span>') !!}
                    
                            <!-- Optional: Display the existing thumbnail if it's a URL or file path -->
                            @if($data->thumbnail)
                                <div class="thumbnail-preview">
                                    <img src="{{ $data->thumbnail }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                </div>
                            @endif
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

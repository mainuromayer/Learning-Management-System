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
                    <h3 class="card-title pt-2 pb-2"> Update Course </h3>
                    <div class="card-tools">
                        <a href="{{ route('course.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Course List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">
                    {!! Form::hidden('id', $data->id) !!}

                    <!-- Title -->
                    <div class="input-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', old('title', $data->title), [
                                'class' => 'form-control required',
                                'placeholder' => 'Title',
                            ]) !!}
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="input-group row {{ $errors->has('short_description') ? 'has-error' : '' }}">
                        {!! Form::label('short_description', 'Short Description: ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('short_description', old('short_description', $data->short_description), [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('short_description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description: ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description', $data->description), [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Create as -->
                    <div class="form-group row {{ $errors->has('create_as') ? 'has-error' : '' }}">
                        {!! Form::label('create_as', 'Create as: ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('create_as', 1, old('create_as', $data->create_as) == 1) !!} Active </label>
                            &nbsp;
                            <label>{!! Form::radio('create_as', 2, old('create_as', $data->create_as) == 2) !!} Inactive </label>
                            &nbsp;
                            <label>{!! Form::radio('create_as', 3, old('create_as', $data->create_as) == 3) !!} Privite </label>
                            &nbsp;
                            <label>{!! Form::radio('create_as', 4, old('create_as', $data->create_as) == 4) !!} Upcoming </label>
                            &nbsp;
                            <label>{!! Form::radio('create_as', 5, old('create_as', $data->create_as) == 5) !!} Pending </label>
                            &nbsp;
                            <label>{!! Form::radio('create_as', 6, old('create_as', $data->create_as) == 6) !!} Draft </label>
                            {!! $errors->first('create_as', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="input-group row {{ $errors->has('category') ? 'has-error' : '' }}">
                        {!! Form::label('category', 'Category: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('category', $category_list, old('category', $data->category_id), [
                                'class' => 'form-control select2 category required',
                            ]) !!}
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div class="input-group row {{ $errors->has('instructor') ? 'has-error' : '' }}">
                        {!! Form::label('instructor', 'Instructor: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('instructor', $instructor_list, old('instructor', $data->instructor_id), [
                                'class' => 'form-control select2 instructor required',
                            ]) !!}
                            {!! $errors->first('instructor', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Course Level -->
                    <div class="input-group row {{ $errors->has('course_level') ? 'has-error' : '' }}">
                        {!! Form::label('course_level', 'Course Level: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('course_level', $course_level_list, old('course_level', $data->course_level), [
                                'class' => 'form-control select2 course_level',
                            ]) !!}
                            {!! $errors->first('course_level', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Pricing Type -->
                    <div class="form-group row {{ $errors->has('pricing_type') ? 'has-error' : '' }}">
                        {!! Form::label('bill', 'Pricing Type?', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <label>{!! Form::radio('pricing_type', 1, old('pricing_type', $data->pricing_type) == 1) !!} Free </label>
                            &nbsp;
                            <label>{!! Form::radio('pricing_type', 2, old('pricing_type', $data->pricing_type) == 2) !!} Paid </label>
                            {!! $errors->first('pricing_type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group row {{ $errors->has('price') ? 'has-error' : '' }}">
                        {!! Form::label('price', 'Price: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-3">
                            <div class="input-group">
                                {!! Form::text('price', old('price', $data->price) ?? '0.00', [
                                    'class' => 'form-control',
                                    'placeholder' => '0.00',
                                    'step' => '0.01'
                                ]) !!}
                                <span class="input-group-text bg-primary text-white">
                                    <i class="bx bx-money"></i>
                                </span>
                            </div>
                            {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <!-- Discount -->
                    <div class="form-group row {{ $errors->has('discount_price') ? 'has-error' : '' }}">
                        {!! Form::label('discount_price', 'Discount Price: ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-3">
                            <div class="input-group">
                                {!! Form::text('discount_price', old('discount_price', $data->discount_price) ?? '0.00', [
                                    'class' => 'form-control',
                                    'placeholder' => '0.00',
                                    'step' => '0.01'
                                ]) !!}
                                <span class="input-group-text bg-primary text-white">
                                    <i class="bx bxs-discount"></i>
                                </span>
                            </div>
                            {!! $errors->first('discount_price', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <!-- Thumbnail (optional) -->
                    <div class="input-group row {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
                        {!! Form::label('thumbnail', 'Thumbnail (optional):', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <img id="newThumbnail" src="{{ old('thumbnail', $data->thumbnail) ? asset($data->thumbnail) : asset('images/no_image.png') }}" style="height:120px;"/>
                            {!! Form::file('thumbnail', ['class' => 'form-control mt-3', 'id' => 'thumbnail', 'oninput' => "document.getElementById('newThumbnail').src=window.URL.createObjectURL(this.files[0])"]) !!}
                            {!! $errors->first('thumbnail', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="input-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', 'Status: ', ['class' => 'col-md-3 control-label  required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('status', $status_list, old('status', $data->status), [
                                'class' => 'form-control select2 required',
                            ]) !!}
                            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
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

            </div>
        </div>
    </div>

    {!! form::close() !!}

@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $('.select2').select2({
            tags: true, // Allow custom input (keywords)
            tokenSeparators: [',', ' '], // Keywords can be separated by commas or spaces
            placeholder: 'Select Keywords',
            allowClear: true
        });
    </script>
@endsection

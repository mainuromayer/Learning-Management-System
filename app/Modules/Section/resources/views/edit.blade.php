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
        'route' => 'section.store',
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
                    <h3 class="card-title pt-2 pb-2">Update Section</h3>
                    <div class="card-tools">
                        <a href="{{ route('section.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Section List
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

                    <!-- Course -->
                    <div class="input-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('course', 'Course:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('course', $course_list, old('course', $data->course_id), [
                                'class' => 'form-control select2 course required',
                            ]) !!}
                            {!! $errors->first('course', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="input-group row {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', 'Status:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('status', $status_list, old('status', $data->status), [
                                'class' => 'form-control select2 categories required',
                            ]) !!}
                            {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>


                    <!-- Update Button -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <script>
        $('.select2').select2({
            placeholder: 'Select One',
            allowClear: true
        });
    </script>
@endsection

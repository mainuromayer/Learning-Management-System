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
        'route' => 'assignment.store',
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
                    <h3 class="card-title pt-2 pb-2">Update Assignment</h3>
                    <div class="card-tools">
                        <a href="{{ route('assignment.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Assignment List
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

                    <!-- Description -->
                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description', $data->description), [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
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

                    <!-- Attachment -->
                    <div class="input-group row {{ $errors->has('attachment') ? 'has-error' : '' }}">
                        {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('attachment_path', isset($data->attachment) ? json_decode($data->attachment)[0] : '', [
                                'class' => 'form-control mt-3',
                                'readonly' => 'readonly', // Make it read-only
                            ]) !!}

                            <!-- Show old attachment link if available -->
                            @if(isset($data->attachment) && json_decode($data->attachment)[0])
                                <div class="mt-2">
                                    <a href="{{ asset(json_decode($data->attachment)[0]) }}" target="_blank">View Current Attachment</a>
                                </div>
                            @endif

                            {!! Form::file('attachment', ['class' => 'form-control mt-3', 'id' => 'attachment']) !!}
                            {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
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

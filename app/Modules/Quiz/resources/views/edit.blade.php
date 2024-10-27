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
        'route' => 'quiz.store',
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
                    <h3 class="card-title pt-2 pb-2"> Update Quiz </h3>
                    <div class="card-tools">
                        <a href="{{ route('quiz.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Quiz List
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
                        {!! Form::label('description', 'Description: ', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description', $data->description), [
                                'class' => 'form-control',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Section -->
                    <div class="input-group row mb-3 {{ $errors->has('section') ? 'has-error' : '' }}">
                        {!! Form::label('section', 'Section: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('section', $section_list, old('section', $data->course_section_id), [
                                'class' => 'form-control select2 section required',
                            ]) !!}
                            {!! $errors->first('section', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="input-group row mb-3 {{ $errors->has('hours') || $errors->has('minutes') || $errors->has('seconds') ? 'has-error' : '' }}">
                        {!! Form::label('duration', 'Duration:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                {!! Form::number('hours', old('hours', floor($data->total_seconds / 3600)), ['class' => 'form-control mr-2 required', 'placeholder' => 'Hours', 'min' => '0']) !!}
                                {!! $errors->first('hours', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('minutes', old('minutes', floor(($data->total_seconds % 3600) / 60)), ['class' => 'form-control mr-2 required', 'placeholder' => 'Minutes', 'min' => '0']) !!}
                                {!! $errors->first('minutes', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('seconds', old('seconds', $data->total_seconds % 60), ['class' => 'form-control mr-2 required', 'placeholder' => 'Seconds', 'min' => '0']) !!}
                                {!! $errors->first('seconds', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <!-- Total Mark & Pass Mark & Retake -->
                    <div class="input-group row mb-3 {{ $errors->has('total_mark') || $errors->has('pass_mark') || $errors->has('retake') ? 'has-error' : '' }}">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::label('total_mark', 'Total Mark:', ['class' => 'control-label required-star']) !!}
                                    {!! Form::number('total_mark', old('total_mark', $data->total_mark), ['class' => 'form-control required', 'placeholder' => 'Total Mark']) !!}
                                    {!! $errors->first('total_mark', '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('pass_mark', 'Pass Mark:', ['class' => 'control-label required-star']) !!}
                                    {!! Form::number('pass_mark', old('pass_mark', $data->pass_mark), ['class' => 'form-control required', 'placeholder' => 'Pass Mark']) !!}
                                    {!! $errors->first('pass_mark', '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class="col-md-4">
                                    {!! Form::label('retake', 'Retake:', ['class' => 'control-label required-star']) !!}
                                    {!! Form::number('retake', old('retake', $data->retake), ['class' => 'form-control required', 'placeholder' => 'Retake']) !!}
                                    {!! $errors->first('retake', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
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
            placeholder: 'Select One',
            allowClear: true
        });
    </script>
@endsection

@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    {!! Form::open([
        'route' => ['enroll_student.store'],
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
                    <h3 class="card-title pt-2 pb-2">Enroll Student</h3>
                    <div class="card-tools">
                        <a href="{{ route('enroll_student.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Enrollment List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">
                    <!-- Student -->
                    <div class="input-group row">
                        {!! Form::label('student', 'Student: ', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('student_id', $student_list, old('student_id'), [
                                'class' => 'form-control select2 student required',
                            ]) !!}
                            {!! $errors->first('student_id', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Course Selection (Multiple) -->
                    <div class="input-group row">
                        {!! Form::label('course_id', 'Courses:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('course_id[]', $course_list, old('course_id'), [
                                'class' => 'form-control select2 required',
                                'multiple' => 'multiple',
                                'data-placeholder' => 'Select Courses'
                            ]) !!}

                            {!! $errors->first('course_id', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <hr>

                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Enroll Student', [
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select Options',
                allowClear: true
            });
        });
    </script>
@endsection

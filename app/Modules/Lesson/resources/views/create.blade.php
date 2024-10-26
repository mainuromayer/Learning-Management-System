@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .select2 {
            width: 100% !important;
        }

        .dynamic-fields {
            display: none; /* Hide dynamic fields initially */
        }
    </style>
@endsection

@section('content')
    {!! Form::open([
        'route' => 'lesson.store',
        'method' => 'post',
        'id' => 'form_id',
        'files' => true,
        'role' => 'form',
    ]) !!}

    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Create New Lesson</h3>
                    <div class="card-tools">
                        <a href="{{ route('lesson.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Lesson List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Lesson Type -->
                    <div class="input-group row {{ $errors->has('lesson_type') ? 'has-error' : '' }}">
                        {!! Form::label('lesson_type', 'Lesson Type:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('lesson_type', $lesson_type_list, old('lesson_type'), [
                                'class' => 'form-control select2 required',
                                'id' => 'lesson_type_select'
                            ]) !!}
                            {!! $errors->first('lesson_type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Common Fields (Initially Hidden) -->
                    <div id="common-fields" style="display: none;">
                        <!-- Title -->
                        <div class="input-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!! Form::label('title', 'Title:', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::text('title', old('title'), [
                                    'class' => 'form-control required',
                                    'placeholder' => 'Title',
                                ]) !!}
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Section -->
                        <div class="input-group row mb-3 {{ $errors->has('section') ? 'has-error' : '' }}">
                            {!! Form::label('section', 'Section: ', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::select('section', $section_list, old('section'), [
                                    'class' => 'form-control select2 section required',
                                ]) !!}
                                {!! $errors->first('section', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="input-group row mb-3 {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status', 'Status:', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::select('status', $status_list, old('status'), [
                                    'class' => 'form-control select2 categories required',
                                ]) !!}
                                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Fields (Hidden initially) -->
                    <div id="dynamic-fields" class="dynamic-fields"></div>

                    <!-- Form Buttons -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Add', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                            {!! Form::button('Reset', ['type' => 'button', 'class' => 'btn btn-secondary', 'id' => 'reset_button']) !!}
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
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select One',
                allowClear: true
            });

            $('#dynamic-fields').hide(); // Hide dynamic fields initially
            $('#common-fields').hide(); // Initially hide common fields

            $('#lesson_type_select').change(function () {
                var selectedType = $(this).val();
                $('#dynamic-fields').empty().hide(); // Clear and hide dynamic fields
                $('#common-fields').hide(); // Hide common fields

                // Reset old values in common fields
                $('#common-fields input[type="text"], #common-fields input[type="number"], #common-fields textarea').val('');
                $('#common-fields select').prop('selectedIndex', 0).trigger('change');

                // Show relevant fields based on the selected lesson type
                if (selectedType) {
                    $('#common-fields').show(); // Show common fields

                    $('#dynamic-fields').show(); // Show dynamic fields

                    if (selectedType === 'youtube_video') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('video') ? 'has-error' : '' }}">
                            {!! Form::label('video', 'Video:', ['class' => 'col-md-3 control-label']) !!}
                                <div class="col-md-9">
                                {!! Form::text('video', old('video'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Video Url',
                                ]) !!}
                            {!! $errors->first('video', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('hours') || $errors->has('minutes') || $errors->has('seconds') ? 'has-error' : '' }}">
                            {!! Form::label('duration', 'Duration:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::number('hours', old('hours', floor($duration / 3600)), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => '0']) !!}
                                    {!! $errors->first('hours', '<span class="help-block">:message</span>') !!}

                                    {!! Form::number('minutes', old('minutes', floor(($duration % 3600) / 60)), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => '0']) !!}
                                    {!! $errors->first('minutes', '<span class="help-block">:message</span>') !!}

                                    {!! Form::number('seconds', old('seconds', $duration % 60), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => '0']) !!}
                                    {!! $errors->first('seconds', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary'), [
                                'class' => 'form-control',
                                'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'image') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('attachment') ? 'has-error' : '' }}">
                            {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::file('attachment', [
                                    'class' => 'form-control',
                                    'id' => 'attachment',
                                ]) !!}
                            {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary'), [
                                'class' => 'form-control',
                                'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'video' || selectedType === 'google_drive') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('video') ? 'has-error' : '' }}">
                            {!! Form::label('video', 'Video:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                            {!! Form::text('video', old('video'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Video Url',
                                    ]) !!}
                            {!! $errors->first('video', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('hours') || $errors->has('minutes') || $errors->has('seconds') ? 'has-error' : '' }}">
                            {!! Form::label('duration', 'Duration:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::number('hours', old('hours', floor($duration / 3600)), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => '0']) !!}
                                    {!! $errors->first('hours', '<span class="help-block">:message</span>') !!}

                                    {!! Form::number('minutes', old('minutes', floor(($duration % 3600) / 60)), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => '0']) !!}
                                    {!! $errors->first('minutes', '<span class="help-block">:message</span>') !!}

                                    {!! Form::number('seconds', old('seconds', $duration % 60), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => '0']) !!}
                                    {!! $errors->first('seconds', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>


                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                            {!! Form::textarea('summary', old('summary'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                    ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'text') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('text') ? 'has-error' : '' }}">
                            {!! Form::label('text', 'Text Content::', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                            {!! Form::textarea('text', old('text'), [
                                'class' => 'form-control',
                                'placeholder' => 'Text Content',
                                ]) !!}
                            {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'iframe') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('iframe', 'Iframe Embed Code:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('iframe', old('iframe'), [
                                    'class' => 'form-control',
                                ]) !!}
                            {!! $errors->first('iframe', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'document') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('document') ? 'has-error' : '' }}">
                            {!! Form::label('document', 'Upload Document:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::file('document', [
                                    'class' => 'form-control',
                                    'id' => 'document',
                                ]) !!}
                            {!! $errors->first('document', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('attachment') ? 'has-error' : '' }}">
                            {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::file('attachment', [
                                    'class' => 'form-control',
                                    'id' => 'attachment',
                                ]) !!}
                            {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    }
                }
            });

            // Reset button functionality
            $('#reset_button').click(function () {
                $('#form_id')[0].reset(); // Reset form
                $('#common-fields').show(); // Show common fields
                $('#dynamic-fields').empty().hide(); // Clear and hide dynamic fields
            });
        });
    </script>
@endsection

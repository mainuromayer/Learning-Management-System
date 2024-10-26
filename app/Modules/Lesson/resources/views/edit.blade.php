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
    {!! Form::model($data, [
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
                    <h3 class="card-title pt-2 pb-2">Edit Lesson</h3>
                    <div class="card-tools">
                        <a href="{{ route('lesson.list') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-list-ul pr-2"></i> Lesson List
                        </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Lesson Type -->
                    <div class="input-group row mb-3 {{ $errors->has('lesson_type') ? 'has-error' : '' }}">
                        {!! Form::label('lesson_type', 'Lesson Type:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('lesson_type', $lesson_type_list, old('lesson_type', $data->lesson_type), [
                                'class' => 'form-control select2 required',
                                'id' => 'lesson_type_select'
                            ]) !!}
                            {!! $errors->first('lesson_type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Common Fields (Initially Hidden) -->
                    <div id="common-fields" style="display: none;">
                        <div class="input-group row mb-3 {{ $errors->has('title') ? 'has-error' : '' }}">
                            {!! Form::label('title', 'Title:', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::text('title', old('title', $data->title), [
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
                                {!! Form::select('section', $section_list, old('section', $data->course_section_id), [
                                    'class' => 'form-control select2 section required',
                                ]) !!}
                                {!! $errors->first('section', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('status') ? 'has-error' : '' }}">
                            {!! Form::label('status', 'Status:', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::select('status', $status_list, old('status', $data->status), [
                                    'class' => 'form-control select2 required',
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
                            {!! Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
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

            $('#dynamic-fields').hide();
            $('#common-fields').hide();


            function showDynamicFields(selectedType) {
                $('#dynamic-fields').empty().hide();
                $('#common-fields').hide();


                if (selectedType) {
                    $('#common-fields').show();

                    $('#dynamic-fields').show();

                    if (selectedType === 'youtube_video') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('video') ? 'has-error' : '' }}">
                            {!! Form::label('video', 'Video:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('video', old('video', $data->video), [
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
                                {!! Form::number('hours', old('hours', floor($data->total_seconds / 3600)), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => '0']) !!}
                                {!! $errors->first('hours', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('minutes', old('minutes', floor(($data->total_seconds % 3600) / 60)), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => '0']) !!}
                                {!! $errors->first('minutes', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('seconds', old('seconds', $data->total_seconds % 60), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => '0']) !!}
                                {!! $errors->first('seconds', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'image') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row {{ $errors->has('attachment') ? 'has-error' : '' }}">
                            {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('attachment_path', isset($data->attachment) ? json_decode($data->attachment)[0] : '', [
                                    'class' => 'form-control mt-3',
                                    'readonly' => 'readonly', // Make it read-only
                                ]) !!}

                                @if(isset($data->attachment) && json_decode($data->attachment)[0])
                                <div class="mt-2">
                                    <a href="{{ asset(json_decode($data->attachment)[0]) }}" target="_blank">View Current Attachment</a>
                                </div>
                                @endif

                                {!! Form::file('attachment', ['class' => 'form-control mt-3', 'id' => 'attachment']) !!}
                                {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
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
                                {!! Form::text('video', old('video', $data->video), [
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
                                {!! Form::number('hours', old('hours', floor($data->total_seconds / 3600)), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => '0']) !!}
                                {!! $errors->first('hours', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('minutes', old('minutes', floor(($data->total_seconds % 3600) / 60)), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => '0']) !!}
                                {!! $errors->first('minutes', '<span class="help-block">:message</span>') !!}

                                {!! Form::number('seconds', old('seconds', $data->total_seconds % 60), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => '0']) !!}
                                {!! $errors->first('seconds', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
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
                                {!! Form::textarea('text', old('text', $data->text), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Text Content',
                                ]) !!}
                            {!! $errors->first('text', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'iframe') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row mb-3 {{ $errors->has('iframe') ? 'has-error' : '' }}">
                            {!! Form::label('iframe', 'iframe:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('iframe', old('iframe', $data->iframe), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Iframe Embed Code:',
                                ]) !!}
                            {!! $errors->first('iframe', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    } else if (selectedType === 'document') {
                        $('#dynamic-fields').append(`
                        <div class="input-group row {{ $errors->has('document') ? 'has-error' : '' }}">
                            {!! Form::label('document', 'Upload Document:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('document_path', isset($data->document) ? json_decode($data->document)[0] : '', [
                                    'class' => 'form-control mt-3',
                                    'readonly' => 'readonly', // Make it read-only
                                ]) !!}

                                @if(isset($data->document) && json_decode($data->document)[0])
                                <div class="mt-2">
                                    <a href="{{ asset(json_decode($data->document)[0]) }}" target="_blank">View Current Document</a>
                                </div>
                                @endif

                                {!! Form::file('attachment', ['class' => 'form-control mt-3', 'id' => 'attachment']) !!}
                            {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row {{ $errors->has('attachment') ? 'has-error' : '' }}">
                            {!! Form::label('attachment', 'Attachment:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::text('attachment_path', isset($data->attachment) ? json_decode($data->attachment)[0] : '', [
                                    'class' => 'form-control mt-3',
                                    'readonly' => 'readonly', // Make it read-only
                                ]) !!}

                                @if(isset($data->attachment) && json_decode($data->attachment)[0])
                                <div class="mt-2">
                                    <a href="{{ asset(json_decode($data->attachment)[0]) }}" target="_blank">View Current Attachment</a>
                                </div>
                                @endif

                                {!! Form::file('attachment', ['class' => 'form-control mt-3', 'id' => 'attachment']) !!}
                            {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row mb-3 {{ $errors->has('summary') ? 'has-error' : '' }}">
                            {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::textarea('summary', old('summary', $data->summary), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Summary',
                                ]) !!}
                            {!! $errors->first('summary', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>`);
                    }
                }
            }

            // Load the existing data when the page loads
            var initialLessonType = $('#lesson_type_select').val();
            showDynamicFields(initialLessonType);

            // Handle change event for lesson type
            $('#lesson_type_select').change(function () {
                var selectedType = $(this).val();
                showDynamicFields(selectedType);
            });

            // Reset button functionality
            $('#reset_button').click(function () {
                $('#form_id')[0].reset();
                $('#lesson_type_select').val(null).trigger('change');
                $('#dynamic-fields').empty().hide();
                $('#common-fields').hide();
            });
        });
    </script>
@endsection

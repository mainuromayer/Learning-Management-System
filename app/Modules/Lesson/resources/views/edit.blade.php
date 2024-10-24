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

        .gap {
            margin-bottom: 20px; /* Add gap between fields */
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
                    <div class="input-group row {{ $errors->has('lesson_type') ? 'has-error' : '' }}">
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
                        <div class="input-group row gap {{ $errors->has('title') ? 'has-error' : '' }}">
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
                        <div class="input-group row {{ $errors->has('section') ? 'has-error' : '' }}">
                            {!! Form::label('section', 'Section: ', ['class' => 'col-md-3 control-label required-star']) !!}
                            <div class="col-md-9">
                                {!! Form::select('section', $section_list, old('section', $data->course_section_id), [
                                    'class' => 'form-control select2 section required',
                                ]) !!}
                                {!! $errors->first('section', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="input-group row gap {{ $errors->has('status') ? 'has-error' : '' }}">
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

            $('#dynamic-fields').hide(); // Hide dynamic fields initially
            $('#common-fields').hide(); // Initially hide common fields

            // Show fields based on the selected lesson type during edit
            function showDynamicFields(selectedType) {
                $('#dynamic-fields').empty().hide(); // Clear and hide dynamic fields
                $('#common-fields').hide(); // Hide common fields

                if (selectedType) {
                    $('#common-fields').show(); // Show common fields

                    $('#dynamic-fields').show(); // Show dynamic fields based on lesson type

                    if (selectedType === 'youtube_video') {
                        $('#dynamic-fields').append(`
                            <div class="input-group row gap">
                                {!! Form::label('video_url', 'YouTube Video URL:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
{!! Form::text('video_url', old('video_url', $data->video_url), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="input-group row gap">
{!! Form::label('duration', 'Duration:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
{!! Form::number('hours', old('hours', floor($data->duration / 3600)), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => 0]) !!}
                        {!! Form::number('minutes', old('minutes', floor(($data->duration % 3600) / 60)), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => 0, 'max' => 59]) !!}
                        {!! Form::number('seconds', old('seconds', $data->duration % 60), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => 0, 'max' => 59]) !!}
                        </div>
                    </div>
                </div>
                <div class="input-group row gap">
{!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
{!! Form::textarea('summary', old('summary', $data->summary), ['class' => 'form-control']) !!}
                        </div>
                    </div>`);
                    } else if (selectedType === 'image') {
                        $('#dynamic-fields').append(`
                            <div class="input-group row gap">
                                {!! Form::label('attachment', 'Upload Image:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
{!! Form::file('attachment', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="input-group row gap">
{!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
{!! Form::textarea('summary', old('summary', $data->summary), ['class' => 'form-control']) !!}
                        </div>
                    </div>`);
                    } else if (selectedType === 'video') {
                        $('#dynamic-fields').append(`
                    <div class="input-group row gap">
                        {!! Form::label('video_file', 'Upload Video File:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::file('video_file', ['class' => 'form-control']) !!}
                        @if (!empty($lesson->video_file))
                        <small>Current File: <a href="{{ asset('uploads/' . $lesson->video_file) }}" target="_blank">{{ $lesson->video_file }}</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="input-group row gap">
                        {!! Form::label('duration', 'Duration:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            <div class="input-group">
                                {!! Form::number('hours', old('hours', $lesson->hours), ['class' => 'form-control mr-2', 'placeholder' => 'Hours', 'min' => 0]) !!}
                        {!! Form::number('minutes', old('minutes', $lesson->minutes), ['class' => 'form-control mr-2', 'placeholder' => 'Minutes', 'min' => 0, 'max' => 59]) !!}
                        {!! Form::number('seconds', old('seconds', $lesson->seconds), ['class' => 'form-control mr-2', 'placeholder' => 'Seconds', 'min' => 0, 'max' => 59]) !!}
                        </div>
                    </div>
                </div>
                <div class="input-group row gap">
{!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('summary', old('summary', $lesson->summary), ['class' => 'form-control']) !!}
                        </div>
                    </div>`);
                    } else if (selectedType === 'text') {
                        $('#dynamic-fields').append(`
                    <div class="input-group row gap">
                        {!! Form::label('text', 'Text Content:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('text', old('text', $lesson->text), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="input-group row gap">
                        {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('summary', old('summary', $lesson->summary), ['class' => 'form-control']) !!}
                        </div>
                    </div>`);
                    } else if (selectedType === 'iframe') {
                        $('#dynamic-fields').append(`
                    <div class="input-group row gap">
                        {!! Form::label('iframe', 'Iframe Embed Code:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('iframe', old('iframe', $lesson->iframe), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="input-group row gap">
                        {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('summary', old('summary', $lesson->summary), ['class' => 'form-control']) !!}
                        </div>
                    </div>`);
                    } else if (selectedType === 'document') {
                        $('#dynamic-fields').append(`
                    <div class="input-group row gap">
                        {!! Form::label('document', 'Upload Document:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::file('document', ['class' => 'form-control']) !!}
                        @if (!empty($lesson->document))
                        <small>Current Document: <a href="{{ asset('uploads/' . $lesson->document) }}" target="_blank">{{ $lesson->document }}</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="input-group row gap">
                        {!! Form::label('attachment', 'Attachment (if any):', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::file('attachment', ['class' => 'form-control']) !!}
                        @if (!empty($lesson->attachment))
                        <small>Current Attachment: <a href="{{ asset('uploads/' . $lesson->attachment) }}" target="_blank">{{ $lesson->attachment }}</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="input-group row gap">
                        {!! Form::label('summary', 'Summary:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('summary', old('summary', $lesson->summary), ['class' => 'form-control']) !!}
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

@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- FontIconPicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fonticonpicker/dist/css/base/jquery.fonticonpicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fonticonpicker/dist/css/themes/grey-theme/jquery.fonticonpicker.grey.min.css">

    <style>
        .select2 {
            width: 100% !important;
        }
        .icon-item {
            font-size: 30px;
            margin: 5px;
            cursor: pointer;
        }
        .icon-item:hover {
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    {!! Form::open([
        'route' => 'category.store',
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
                    <h3 class="card-title pt-2 pb-2"> Create New Category </h3>
                    <div class="card-tools">
                        <a href="{{ route('category.list') }}" class="btn btn-sm btn-primary"><i class="bx bx-list-ul pr-2"></i> Category List </a>
                    </div>
                </div>

                <div class="card-body demo-vertical-spacing">

                    <!-- Category Name -->
                    <div class="input-group row {{ $errors->has('category_name') ? 'has-error' : '' }}">
                        {!! Form::label('category_name', 'Category Name:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('category_name', old('category_name'), [
                                'class' => 'form-control required',
                                'placeholder' => 'Category Name'
                            ]) !!}
                            {!! $errors->first('category_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Icon Picker -->
                    <div class="input-group row {{ $errors->has('icon') ? 'has-error' : '' }}">
                        {!! Form::label('icon', 'Icon:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('icon', old('icon') ?: '', [
                                'class' => 'form-control mb-2 required',
                                'placeholder' => 'Icon (bx bx-user)',
                                'id' => 'icon-picker-input',
                                'readonly' => true
                            ]) !!}
                            <button type="button" class="btn btn-primary" id="icon-picker-button">
                                <i class="bx bx-search"></i> Select Icon
                            </button>
                            {!! $errors->first('icon', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Keywords (multiple select for JSON) -->
                    <div class="input-group row {{ $errors->has('keywords') ? 'has-error' : '' }}">
                        {!! Form::label('keywords', 'Keywords:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::select('keywords[]', [], null, [
                                'class' => 'form-control select2',
                                'multiple' => 'multiple',
                                'data-placeholder' => 'Enter Keywords',
                            ]) !!}
                            {!! $errors->first('keywords', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Description (optional) -->
                    <div class="input-group row {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! Form::label('description', 'Description:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::textarea('description', old('description'), [
                                'class' => 'form-control',
                                'placeholder' => 'Description',
                            ]) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Thumbnail (optional) -->
                    <div class="input-group row {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
                        {!! Form::label('thumbnail', 'Thumbnail (optional):', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <img id="newThumbnail" src="{{ asset('images/no_image.png') }}" style="height:120px;" />
                            {!! Form::file('thumbnail', [
                                'class' => 'form-control mt-3',
                                'id' => 'thumbnail',
                                'oninput' => "document.getElementById('newThumbnail').src=window.URL.createObjectURL(this.files[0])",
                            ]) !!}
                            {!! $errors->first('thumbnail', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <hr>

                    <!-- Category Logo (optional) -->
                    <div class="input-group row {{ $errors->has('category_logo') ? 'has-error' : '' }}">
                        {!! Form::label('category_logo', 'Category Logo (optional):', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            <img id="newCategoryLogo" src="{{ asset('images/no_image.png') }}" style="height:120px;" />
                            {!! Form::file('category_logo', [
                                'class' => 'form-control mt-3',
                                'id' => 'category_logo',
                                'oninput' => "document.getElementById('newCategoryLogo').src=window.URL.createObjectURL(this.files[0])",
                            ]) !!}
                            {!! $errors->first('category_logo', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Add and Reset Buttons -->
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

<!-- Modal for Icon Picker -->
<div class="modal fade" id="icon-picker-modal" tabindex="-1" role="dialog" aria-labelledby="icon-picker-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="icon-picker-modal-label">Select Icon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Search Bar -->
                <input type="text" id="icon-search" class="form-control mb-3" placeholder="Search for an icon...">

                <!-- Icon Grid -->
                <div id="icon-grid" class="d-flex flex-wrap">
                    @foreach($boxicons as $icon)
                        <div class="icon-item" data-icon="{{ $icon }}">
                            <i class="bx {{ $icon }}"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

    <!-- FontIconPicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/fonticonpicker@3.0.0/dist/js/jquery.fonticonpicker.min.js"></script>

    <script>
$(document).ready(function () {
    // Initialize Select2
    $('.select2').select2({
        tags: true, // Allow custom input (keywords)
        tokenSeparators: [',', ' '], // Keywords can be separated by commas or spaces
        placeholder: 'Enter Keywords',
        allowClear: true
    });

    // Open the modal when the button is clicked
    $('#icon-picker-button').click(function() {
        $('#icon-picker-modal').modal('show');
    });

    // Handle icon selection
    $('.icon-item').click(function() {
        var selectedIcon = $(this).data('icon');
        $('#icon-picker-input').val('bx ' + selectedIcon); // Set the selected icon class in the input field
        $('#icon-picker-modal').modal('hide'); // Close the modal
    });

    // Filter icons based on search input
    $('#icon-search').on('input', function() {
        var searchValue = $(this).val().toLowerCase();
        $('.icon-item').each(function() {
            var iconClass = $(this).data('icon').toLowerCase();
            if (iconClass.indexOf(searchValue) !== -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Reset form fields when Reset button is clicked
    $('#reset_button').click(function() {
        $('#form_id')[0].reset(); // Reset all form fields
        $('.select2').val(null).trigger('change'); // Reset select2 fields
        $('#newThumbnail').attr('src', '{{ asset('images/no_image.png') }}'); // Reset thumbnail image
        $('#newCategoryLogo').attr('src', '{{ asset('images/no_image.png') }}'); // Reset category logo image
    });
});

    </script>
@endsection

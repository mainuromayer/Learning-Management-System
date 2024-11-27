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
        'route' => 'about_us.store',
        'method' => 'POST',
        'id' => 'form_id',
        'enctype' => 'multipart/form-data',
        'files' => true,
        'role' => 'form',
    ]) !!}

    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">{{ isset($data) ? 'Update About Us' : 'Create About Us' }}</h3>
                </div>
                <div class="card-body demo-vertical-spacing">

                    {!! Form::hidden('id', $data->id ?? null) !!}

                    <!-- Title -->
                    <div class="input-group row {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('title', 'Title:', ['class' => 'col-md-3 control-label required-star']) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', old('title', $data->title ?? ''), [
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
                            {!! Form::textarea('description', old('description', $data->description ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

<!-- Points Section -->
<div class="input-group row {{ $errors->has('points') ? 'has-error' : '' }}">
    {!! Form::label('points', 'Points:', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9">
        <div id="points-wrapper">
            @if (isset($data) && $data->points)
                @foreach (json_decode($data->points) as $point)
                    <div class="input-group mb-3 point-item">
                        {!! Form::text('points[]', $point, ['class' => 'form-control', 'placeholder' => 'Enter point']) !!}
                        <button type="button" class="btn btn-secondary remove-point"><i class="bx bx-no-entry"></i></button>
                    </div>
                @endforeach
            @else
                <div class="input-group mb-3 point-item">
                    {!! Form::text('points[]', '', ['class' => 'form-control', 'placeholder' => 'Enter point']) !!}
                    <button type="button" class="btn btn-secondary remove-point"><i class="bx bx-no-entry"></i></button>
                </div>
            @endif
        </div>
        <button type="button" class="btn btn-success btn-sm mt-2" id="add-point"><i class="bx bx-plus-medical"></i></button>
        {!! $errors->first('points', '<span class="help-block">:message</span>') !!}
    </div>
</div>




        

                    <!-- Address -->
                    <div class="input-group row {{ $errors->has('address') ? 'has-error' : '' }}">
                        {!! Form::label('address', 'Address:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('address', old('address', $data->address ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="input-group row {{ $errors->has('phone') ? 'has-error' : '' }}">
                        {!! Form::label('phone', 'Phone:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::text('phone', old('phone', $data->phone ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="input-group row {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'Email:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::email('email', old('email', $data->email ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="input-group row {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        {!! Form::label('facebook', 'Facebook:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::url('facebook', old('facebook', $data->facebook ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('facebook', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        {!! Form::label('twitter', 'Twitter:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::url('twitter', old('twitter', $data->twitter ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('twitter', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('youtube') ? 'has-error' : '' }}">
                        {!! Form::label('youtube', 'YouTube:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::url('youtube', old('youtube', $data->youtube ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('youtube', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="input-group row {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                        {!! Form::label('linkedin', 'LinkedIn:', ['class' => 'col-md-3 control-label']) !!}
                        <div class="col-md-9">
                            {!! Form::url('linkedin', old('linkedin', $data->linkedin ?? ''), ['class' => 'form-control']) !!}
                            {!! $errors->first('linkedin', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <!-- Image -->
<div class="input-group row {{ $errors->has('thumbnail') ? 'has-error' : '' }}">
    {!! Form::label('image', 'Image:', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9">
        <img id="newImage" 
             src="{{ old('image', isset($data) && $data->image ? asset('storage/'.$data->image) : asset('images/no_image.png')) }}" 
             style="height:120px;"/>
        {!! Form::file('image', ['class' => 'form-control mt-3', 'id' => 'image', 'oninput' => "document.getElementById('newImage').src=window.URL.createObjectURL(this.files[0])"]) !!}
        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
    </div>
</div>


<!-- Gallery (Multiple Images) -->
<div class="input-group row {{ $errors->has('gallery') ? 'has-error' : '' }}">
    {!! Form::label('gallery', 'Gallery (Images):', ['class' => 'col-md-3 control-label']) !!}
    <div class="col-md-9">
        {!! Form::file('gallery[]', ['class' => 'form-control', 'multiple' => true]) !!}
        {!! $errors->first('gallery', '<span class="help-block">:message</span>') !!}

        @if (isset($data->gallery) && !empty($data->gallery))
            <div class="gallery-images mt-3">
                @foreach (json_decode($data->gallery) as $image)
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" style="height:100px; width:100px;">
                        <div class="remove-image" onclick="removeImage(this, '{{ $image }}')">X</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>




                    <!-- Submit Button -->
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
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

// JavaScript to dynamically add or remove points



$('#add-point').on('click', function() {
        var pointHtml = '<div class="input-group mb-3 point-item">' +
                            '{!! Form::text("points[]", "", ["class" => "form-control", "placeholder" => "Enter point"]) !!}' +
                            '<button type="button" class="btn btn-secondary remove-point"><i class="bx bx-no-entry"></i></button>';
        $('#points-wrapper').append(pointHtml);
    });

// JavaScript to remove gallery image
function removeImage(element, imagePath) {
        // Optionally send AJAX request to remove the image from storage
        if (confirm('Are you sure you want to remove this image?')) {
            // Call an AJAX endpoint to remove the image from storage
            $.ajax({
                url: '{{ route("about_us.remove_image") }}',
                method: 'POST',
                data: function(d) {
                    // Send CSRF token as part of the request data
                    d._token = $('input[name="_token"]').val();
                    d.image = imagePath;  // Add the image path to the data
                },
                success: function(response) {
                    if (response.success) {
                        // If successful, remove the image from the view
                        $(element).closest('.position-relative').remove();
                    } else {
                        alert(response.message || 'Failed to remove image.');
                    }
                },
                error: function() {
                    alert('Failed to remove image.');
                }
            });

// JavaScript to remove a point item
$(document).on('click', '.remove-point', function() {
    $(this).closest('.point-item').remove();
});




    </script>
@endsection

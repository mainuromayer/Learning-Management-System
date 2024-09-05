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
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary form-card">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Update Profile</h3>
                    <div class="card-tools">
                        <!-- <a href="" class="btn btn-primary">Add</a> -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                {!! Form::open([
                'route' => 'profile.update',
                'method' => 'post',
                'id' => 'form_id',
                'enctype' => 'multipart/form-data',
                'files' => 'true',
                'role' => 'form',
                ]) !!}

                <div class="row p-4">

                    <div class="col-md-12">
                        <div class="form-group row has-feedback">
                            <div id="browseimagepp">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                    <div class="col-md-12 addImages">
                                        <label class="center-block image-upload" for="user_pic">
                                            <figure>
                                                <img
                                                    src="{{ !empty($data->image) ? url($data->image) : url('images/no_image.png') }}"
                                                    class="img-responsive img-thumbnail" id="user_pic_preview"
                                                    width="150px" height="150px">
                                            </figure>
                                            <input type="hidden" id="user_pic_base64" name="user_pic_base64" value="">
                                            @if(!empty($data->image))
                                                <input type="hidden" name="user_pic" value="{{$data->image}}"/>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pb-3">
                        <h4 id="profile_image">
                            <label for="user_pic" class="required-star ">Profile image</label>
                        </h4>
                        <p class="text-success fw-bold small">[File Format: *.jpg/ .jpeg/ .png | Width
                            300PX, Height 300PX]</p>
                        <span id="user_err" class="text-danger" style="font-size: 10px;"></span>
                        <input type="file" class="form-control" name="user_pic" id="user_pic"
                               onchange="imageUploadWithCroppingAndDetect(this, 'user_pic_preview', 'user_pic_base64')"
                               size="300x300">
                    </div>

                    <div class="col-md-12 {{$errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email','Email:',['class'=>'control-label required-star pb-1']) !!}
                        <div class="pb-3">
                            {!! Form::text('email', $data->email, ['class' => 'form-control required']) !!}
                            {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-12 {{$errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name','User Name:',['class'=>'control-label required-star pb-1']) !!}
                        <div class="pb-3">
                            {!! Form::text('name', $data->name, ['class' => 'form-control required']) !!}
                            {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="col-md-12 {{$errors->has('user_type') ? 'has-error' : ''}}">
                        {!! Form::label('role','User Type:',['class'=>'control-label required-star pb-1']) !!}
                        <div class="pb-3">
                            {!! Form::text('role', $data->role->title, ['class' => 'form-control required','readonly']) !!}
                            {!! $errors->first('role', '<span class="help-block">:message</span>') !!}

                        </div>
                    </div>


                    <div class="col-md-12">
                        <button class="btn btn-primary">Update</button>
                        <a href="{{ url('reset_password') }}" class="btn btn-primary">Reset Password</a>
                    </div>

                </div>

                {!! form::close() !!}

            </div><!-- /.panel -->

        </div>
    </div>
    @include('plugins/image_upload')
@endsection
@section('footer-script')

    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>


    <script>
        $(document).ready(function () {
            $("#form_id").validate({
                errorPlacement: function () {
                    return true;
                },
            });
        });
    </script>
@endsection

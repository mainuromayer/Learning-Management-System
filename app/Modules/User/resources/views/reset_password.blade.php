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
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Reset Password </h3>
                    <div class="card-tools">
                        <!-- <a href="" class="btn btn-primary">Add</a> -->
                    </div>
                    <!-- /.card-tools -->
                </div>
                {!! Form::open([
                'url' => 'reset_password/update',
                'method' => 'post',
                'id' => 'form_id',
                'enctype' => 'multipart/form-data',
                'files' => 'true',
                'role' => 'form',
                ]) !!}

                <div class="row p-4">
                    <div class="col-md-12 mb-3 {{$errors->has('old_password') ? 'has-error' : ''}}">
                        <div class=" input-group input-group-merge">
                            {!! Form::password('old_password', ['class' => 'form-control required', 'placeholder' => 'Old Password']) !!}
                            {!! $errors->first('old_password','<span class="help-block">:message</span>') !!}
                        </div>

                    </div>

                    <div class="col-md-12 mb-3 {{$errors->has('new_password') ? 'has-error' : ''}}">
                        <div class=" input-group input-group-merge">
                            {!! Form::password('new_password', ['class' => 'form-control required', 'placeholder' => 'New Password']) !!}
                            {!! $errors->first('new_password','<span class="help-block">:message</span>') !!}
                        </div>
                    </div>


                    <div class="col-md-12">
                        <button class="btn btn-primary">Next</button>
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

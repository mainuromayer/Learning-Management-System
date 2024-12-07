@extends('frontend.main')

@section('title')
Register
@endsection

@section('content')

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Registration -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">

                                </span>
                                <a href="" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                                    <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>GUB</h2>
                                </a>
                            </a>
                        </div>
                        <!-- /Logo -->

                        {!! Form::open(['route' => 'register.store', 'method' => 'post', 'id' => 'form_id', 'enctype' => 'multipart/form-data', 'files' => 'true', 'role' => 'form']) !!}
                        
                        <div class="mb-3">
                            <div class=" {{$errors->has('name') ? 'has-error' : ''}}">
                                {!! Form::label('name', 'Full Name', ['class' => 'col-md-12 form-label required-star']) !!}
                                <div class="col-md-12">
                                    {!! Form::text('name', old('name'), ['class' => 'form-control required', 'placeholder' => 'Enter your full name', 'autofocus'=>'true']) !!}
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class=" {{$errors->has('email') ? 'has-error' : ''}}">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-12 form-label required-star']) !!}
                                <div class="col-md-12">
                                    {!! Form::email('email', old('email'), ['class' => 'form-control required', 'placeholder' => 'Enter your email']) !!}
                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class=" {{$errors->has('password') ? 'has-error' : ''}}">
                                {!! Form::label('password', 'Password', ['class' => 'form-label required-star']) !!}
                                <div class="input-group">
                                    {!! Form::password('password', ['class' => 'form-control required', 'placeholder' => 'Enter password']) !!}
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class=" {{$errors->has('password_confirmation') ? 'has-error' : ''}}">
                                {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'form-label required-star']) !!}
                                <div class="input-group">
                                    {!! Form::password('password_confirmation', ['class' => 'form-control required', 'placeholder' => 'Confirm password']) !!}
                                </div>
                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="mb-3">
                            {!! Form::label('role', 'Select Role', ['class' => 'form-label required-star']) !!}
                            <div class="col-md-12">
                                {!! Form::select('role', ['' => 'Select Role', 'student' => 'Student', 'instructor' => 'Instructor'], old('role'), ['class' => 'form-control required']) !!}
                                {!! $errors->first('role', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
                        </div>

                        {!! Form::close() !!}

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Login</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Registration -->
            </div>
        </div>
    </div>

@endsection

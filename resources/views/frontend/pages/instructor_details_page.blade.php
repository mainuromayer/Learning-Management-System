@extends('frontend.index')
@section('title')
    Instructor Details
@endsection
@section('styles')

@endsection

@section('content')

    @include('frontend.layouts.spinner')
    @include('frontend.layouts.navbar')

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center">
            <h1 class="display-4 text-white animated slideInDown mb-4">Insttructor Details</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('instructor_page') }}">Instructor</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Instructor Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    @include('frontend.pages.instructor.instructor_details')
    @include('frontend.layouts.footer')

@endsection

@section('scripts')
@endsection
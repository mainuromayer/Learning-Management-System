@extends('frontend.index')

@section('title')
Home
@endsection

@section('styles')
@endsection


@section('content')
  @include('frontend.layouts.spinner')
  @include('frontend.layouts.navbar')
  @include('frontend.layouts.carousel')
  @include('frontend.layouts.service')
  @include('frontend.layouts.about')
  @include('frontend.layouts.category')
  @include('frontend.layouts.course')
  @include('frontend.layouts.instructor')
  @include('frontend.layouts.testimonial')
  @include('frontend.layouts.footer')
@endsection

@section('scripts')
@endsection

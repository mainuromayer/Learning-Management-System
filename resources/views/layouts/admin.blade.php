@extends('layouts.main')
@section('body')
    @include('partials.messages')
    @yield('content')

@stop

@section('footer-script')
@endsection

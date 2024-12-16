@extends('layouts.admin')

@section('header-resources')
    {{--  @include('partials.datatable-css')  --}}
@endsection

@section('content')
    {{--  @include('partials.messages') --}}

    {{-- @if (Auth::user()->is_approved != 1) --}}
    {{-- @else --}}
    <div class="row">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>
    {{-- @endif --}}
@endsection

@section('footer-script')
    {{-- @yield('chart_script') --}}
    {{-- @include('partials.datatable-js') --}}
    <!-- Include jQuery (if not included already) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

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
@endsection

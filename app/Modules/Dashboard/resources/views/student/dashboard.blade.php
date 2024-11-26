@extends('Dashboard::index')

@section('content')
<div class="container">
  <h2>Welcome, {{ auth()->user()->name }}</h2>

  <h3>Your Enrolled Courses</h3>
  <div class="row">
      @forelse ($courses as $course)
          <div class="col-md-4">
              <div class="card">
                  <img src="{{ $course->thumbnail }}" class="card-img-top" alt="course thumbnail">
                  <div class="card-body">
                      <h5 class="card-title">{{ $course->title }}</h5>
                      <p class="card-text">{{ $course->short_description }}</p>
                      <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">Go to Course</a>
                  </div>
              </div>
          </div>
      @empty
          <p>You are not enrolled in any courses.</p>
      @endforelse
  </div>
</div>
@endsection

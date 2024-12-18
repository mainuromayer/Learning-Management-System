@extends('Dashboard::index')

@section('content')
    <h1>Instructor Dashboard</h1>
    
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-md-4 p-3">
                <div class="card card-outline card-primary overflow-hidden">
                    <div class="card-body mt-4">
                        <h5>{{ $course->title }}</h5>
                        <p>{{ $course->short_description }}</p>
                        <a href="{{ route('instructor.course.index', ['courseId' => $course->id]) }}" class="btn btn-primary">View Course</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

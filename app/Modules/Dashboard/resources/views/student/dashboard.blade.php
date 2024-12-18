@extends('Dashboard::index')

@section('content')
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-md-4 p-3">
                <div class="card card-outline card-primary overflow-hidden">
                    <!-- Display Course Thumbnail -->
                    <div class="text-center">
                        <img class="img-fluid" src="{{ asset('/' . $course->thumbnail) }}"
                            style="width: 100%; height: 200px; object-fit: cover;">
                    </div>

                    <div class="card-body mt-4">
                        <p class="fw-bold">{{ $course->title }}</p>


                        <div class="d-flex justify-content-between mt-3">
                            <p>Lessons
                                ({{ $course->sections->sum(function ($section) {return count($section->lessons);}) }})</p>
                            <p>Quizzes
                                ({{ $course->sections->sum(function ($section) {return count($section->quizzes);}) }})</p>
                            <p>Assignments
                                ({{ $course->sections->sum(function ($section) {return count($section->assignments);}) }})
                            </p>
                        </div>

                        {{-- <h5 class="text-center">Course Progress: {{ $course->progress }}%</h5> --}}

                        <!-- Continue Button -->
                        <div class="text-center mt-3">
                            <a href="{{ route('course.show', ['courseId' => $course->id]) }}" class="btn btn-primary">
                                Continue to Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $courses->links() }}
    </div>
@endsection

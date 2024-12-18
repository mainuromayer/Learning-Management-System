@extends('Dashboard::index')

@section('content')
    <div class="row">
        <div class="col-12 text-center my-4">
            <h2>{{ $course->title }}</h2>
            <div class="mb-3">
                <a href="{{ route('instructor.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>&nbsp; Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Display Sections with Button Toggle for Lessons, Quizzes, and Assignments -->
        @foreach ($course->sections as $section)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-block btn-primary section-toggle" data-toggle="collapse" data-target="#section{{ $section->id }}" aria-expanded="false" aria-controls="section{{ $section->id }}">
                            <i class="fas fa-caret-right"></i>&nbsp; {{ $section->title }}
                        </button>
                    </div>
                    <div id="section{{ $section->id }}" class="collapse">
                        <div class="card-body">
                            <!-- Lessons -->
                            <div class="section-content">
                                <h6>Lessons</h6>
                                @foreach ($section->lessons as $lesson)
                                    <button class="btn btn-outline-dark w-100 lesson-toggle" data-toggle="collapse" data-target="#lesson{{ $lesson->id }}" aria-expanded="false" aria-controls="lesson{{ $lesson->id }}">
                                        <i class="fas fa-caret-right"></i>&nbsp; {{ $lesson->title }}
                                    </button>
                                    <div id="lesson{{ $lesson->id }}" class="collapse ml-3 p-3">
                                        <p><strong>Description:</strong> {{ $lesson->summary }}</p>
                                        <p><strong>Text Content:</strong> {!! nl2br(e($lesson->text)) !!}</p>
                                        <p><strong>Duration:</strong> {{ $lesson->duration }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Quizzes -->
                            <div class="section-content mt-3">
                                <h6>Quizzes</h6>
                                @foreach ($section->quizzes as $quiz)
                                    <button class="btn btn-outline-dark w-100 quiz-toggle" data-toggle="collapse" data-target="#quiz{{ $quiz->id }}" aria-expanded="false" aria-controls="quiz{{ $quiz->id }}">
                                        <i class="fas fa-caret-right"></i>&nbsp; {{ $quiz->title }}
                                    </button>
                                    <div id="quiz{{ $quiz->id }}" class="collapse ml-3 p-3">
                                        <p><strong>Duration:</strong> {{ $quiz->duration }}</p>
                                        <p><strong>Total Marks:</strong> {{ $quiz->total_mark }}</p>
                                        <p><strong>Pass Marks:</strong> {{ $quiz->pass_mark }}</p>
                                        <p><strong>Description:</strong> {{ $quiz->description }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Assignments -->
                            <div class="section-content mt-3">
                                <h6>Assignments</h6>
                                @foreach ($assignments as $assignment)
                                    @if ($assignment->course_section_id == $section->id) <!-- Ensure the assignment belongs to the section -->
                                        <button class="btn btn-outline-dark w-100 assignment-toggle" data-toggle="collapse" data-target="#assignment{{ $assignment->id }}" aria-expanded="false" aria-controls="assignment{{ $assignment->id }}">
                                            <i class="fas fa-caret-right"></i>&nbsp; {{ $assignment->title }}
                                        </button>
                                        <div id="assignment{{ $assignment->id }}" class="collapse ml-3 p-3">
                                            <p><strong>Description:</strong> {{ $assignment->description }}</p>
                                            <p><strong>Instructor:</strong> {{ $assignment->instructor->user->name }}</p>
                                            <p><strong>Status:</strong> {{ $assignment->status }}</p>
                                            @if ($assignment->attachment)
                                                <p><strong>Attachment:</strong> <a href="{{ asset('/' . json_decode($assignment->attachment)[0]) }}" target="_blank">Download</a></p>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection

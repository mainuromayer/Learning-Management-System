@extends('Dashboard::index')

@section('content')
<div class="row">
    @foreach ($enrolledCourses as $enrollment)
        @foreach ($enrollment->courses as $course)
            @if ($course)
                <div class="col-md-4 p-3">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title pt-2 pb-2">{{ $course->title ?? 'Untitled Course' }}</h3>
                        </div>

                        <div class="card-body mt-4">
                            <h5 class="text-center">
                                Course Progress: {{ $course->progress ?? 'Not Available' }}%
                            </h5>

                            <div class="accordion" id="courseSections{{ $course->id }}">
                                @foreach ($course->sections as $section)
                                    @if ($section)
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $section->id }}">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapse{{ $section->id }}" aria-expanded="true"
                                                            aria-controls="collapse{{ $section->id }}">
                                                        {{ $section->title ?? 'Untitled Section' }}
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}"
                                                 data-parent="#courseSections{{ $course->id }}">
                                                <div class="card-body">
                                                    <h6>Lessons:</h6>
                                                    <ul>
                                                        @foreach ($section->lessons as $lesson)
                                                            <li>
                                                                <a href="{{ route('lesson.view', ['lessonId' => $lesson->id]) }}"
                                                                    class="text-decoration-none">{{ $lesson->title ?? 'Untitled Lesson' }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <h6>Quizzes:</h6>
                                                    <ul>
                                                        @foreach ($section->quizzes as $quiz)
                                                            <li>
                                                                <a href="{{ route('quiz.take', ['quizId' => $quiz->id]) }}"
                                                                    class="text-decoration-none">{{ $quiz->title ?? 'Untitled Quiz' }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <h6>Assignments:</h6>
                                                    <ul>
                                                        @foreach ($section->assignments as $assignment)
                                                            <li>
                                                                <a href="{{ route('assignment.view', ['assignmentId' => $assignment->id]) }}"
                                                                    class="text-decoration-none">{{ $assignment->title ?? 'Untitled Assignment' }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>
@endsection
@extends('Dashboard::index')

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">{{ $course->title }}</h3>
                </div>

                <div class="card-body mt-4">
                    <h5>Course Progress: {{ $progress }}%</h5>

                    <div class="accordion" id="courseSections">
                        @foreach ($course->sections as $section)
                            <div class="card">
                                <div class="card-header" id="heading{{ $section->id }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $section->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $section->id }}">
                                            {{ $section->title }}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse{{ $section->id }}" class="collapse" aria-labelledby="heading{{ $section->id }}"
                                     data-parent="#courseSections">
                                    <div class="card-body">
                                        <!-- Lessons -->
                                        <h6>Lessons:</h6>
                                        <ul>
                                            @foreach ($section->lessons as $lesson)
                                                <li>
                                                    <a href="{{ route('lesson.view', ['lessonId' => $lesson->id]) }}">{{ $lesson->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- Quizzes -->
                                        <h6>Quizzes:</h6>
                                        <ul>
                                            @foreach ($section->quizzes as $quiz)
                                                <li>
                                                    <a href="{{ route('quiz.take', ['quizId' => $quiz->id]) }}">{{ $quiz->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- Assignments -->
                                        <h6>Assignments:</h6>
                                        <ul>
                                            @foreach ($section->assignments as $assignment)
                                                <li>
                                                    <a href="{{ route('assignment.view', ['assignmentId' => $assignment->id]) }}">{{ $assignment->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

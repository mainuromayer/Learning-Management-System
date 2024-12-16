@extends('Dashboard::index')

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">{{ $lesson->title }}</h3>
                </div>

                <div class="card-body mt-4">
                    <div class="lesson-content">
                        @if ($lesson->lesson_type === 'video')
                            <video width="100%" controls>
                                <source src="{{ asset('storage/' . $lesson->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif($lesson->lesson_type === 'iframe')
                            <iframe src="{{ $lesson->iframe }}" width="100%" height="400px"></iframe>
                        @elseif($lesson->lesson_type === 'text')
                            <p>{{ $lesson->text }}</p>
                        @endif

                        @if ($lesson->attachment)
                            <h5>Attachments:</h5>
                            <ul>
                                @foreach (json_decode($lesson->attachment) as $file)
                                    <li><a href="{{ asset('storage/' . $file) }}" target="_blank">{{ basename($file) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    @if ($lesson->nextLesson)
                        <a href="{{ route('lesson.view', ['lessonId' => $lesson->nextLesson->id]) }}"
                            class="btn btn-primary btn-sm">Continue to Next Lesson</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="btn btn-success btn-sm">Back to Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

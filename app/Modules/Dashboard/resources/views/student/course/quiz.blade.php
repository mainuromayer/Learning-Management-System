@extends('Dashboard::index')

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">{{ $quiz->title }}</h3>
                </div>

                <div class="card-body mt-4">
                    <form action="{{ route('quiz.submit', ['quizId' => $quiz->id]) }}" method="POST">
                        @csrf
                        @foreach ($quiz->questions as $question)
                            <div class="form-group">
                                <label>{{ $question->text }}</label>
                                <div>
                                    @foreach ($question->options as $option)
                                        <div>
                                            <input type="radio" name="question_{{ $question->id }}"
                                                value="{{ $option->id }}">
                                            <label>{{ $option->text }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-success">Submit Quiz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

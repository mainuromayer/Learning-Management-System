@extends('Dashboard::index')

@section('content')
    <div class="container">
        <h1>Assignments</h1>
        <div class="row">
            @foreach ($assignments as $assignment)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $assignment->title }}</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Description:</strong> {{ $assignment->description }}</p>
                            <p><strong>Section:</strong> {{ $assignment->section->title }}</p>

                            @if ($assignment->attachment)
                                <p><strong>Attachments:</strong></p>
                                <ul>
                                    @foreach ($assignment->attachment as $file)
                                        <li><a href="{{ Storage::url($file) }}" target="_blank">{{ basename($file) }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $assignments->links() }}
    </div>
@endsection

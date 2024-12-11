@extends('Dashboard::index')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">My Courses</h3>
                </div>

                <div class="card-body mt-4">
                    <div class="row" id="course-grid">
                        @foreach($courses as $course)
                            <div class="col-md-4 mb-4">
                                <div class="card" style="height: 100%;">
                                    <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('images/no_image.png') }}" alt="{{ $course->title }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column" style="height: 100%;">
                                        <h5 class="card-title py-3">{{ $course->title }}</h5>
                                        <p class="card-text text-muted flex-grow-1">{{ $course->short_description ?? 'No description available' }}</p>
                                        <p><strong>Instructor:</strong> {{ $course->instructor->user->name ?? 'Unknown Instructor' }}</p>

                                        <!-- Progress Bar -->
                                        <div class="progress mb-3">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $course->progress }}%" aria-valuenow="{{ $course->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $course->progress }}%</div>
                                        </div>

                                        <!-- Continue Button -->
                                        <a href="{{ route('course.continue', ['courseId' => $course->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-play-circle"></i> Continue
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="pagination" class="mt-3">
                        <!-- Pagination controls will be dynamically loaded here -->
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable_js')

    <script>
function loadCourses(page) {
    // Disable pagination buttons and show loading spinner
    $('#pagination button').prop('disabled', true);
    $('#course-grid').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');

    $.ajax({
        url: "{{ route('student.courses') }}", // Fetch courses route
        method: 'post',
        data: {
            _token: $('input[name="_token"]').val(),
            page: page
        },
        success: function (data) {
            let courses = data.data;
            let courseGrid = $('#course-grid');
            let pagination = $('#pagination');

            courseGrid.empty();  // Clear previous courses

            courses.forEach(function (course) {
                let thumbnail = course.thumbnail ? "/" + course.thumbnail : "{{ asset('images/no_image.png') }}";
                let description = course.short_description ? course.short_description : 'No description available';
                let instructorName = course.instructor && course.instructor.user ? course.instructor.user.name : 'Unknown Instructor';

                let progress = course.progress ? course.progress : 0; // Assuming progress is a percentage

                let courseHtml = `
                    <div class="col-md-4 mb-4">
                        <div class="card" style="height: 100%;">
                            <img src="${thumbnail}" alt="${course.title}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body d-flex flex-column" style="height: 100%;">
                                <h5 class="card-title py-3">${course.title}</h5>
                                <p class="card-text text-muted flex-grow-1">${description}</p>
                                <p><strong>Instructor:</strong> ${instructorName}</p>

                                <!-- Progress Bar -->
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: ${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">${progress}%</div>
                                </div>

                                <!-- Continue Button -->
                                <a href="/course/${course.id}/continue" class="btn btn-primary btn-sm">
                                    <i class="bx bx-play-circle"></i> Continue
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                courseGrid.append(courseHtml);
            });

            // Update pagination buttons
            const total = data.pagination.total;
            const current = data.pagination.current_page;
            const last = data.pagination.last_page;

            pagination.empty();

            let prevButton = `<button class="btn btn-sm btn-secondary mx-1" data-page="${current - 1}" ${current === 1 ? 'disabled' : ''}>Prev</button>`;
            pagination.append(prevButton);

            for (let i = 1; i <= last; i++) {
                if (i === 1 || i === last || (i >= current - 1 && i <= current + 1)) {
                    let pageButton = `<button class="btn btn-sm ${i === current ? 'btn-primary' : 'btn-secondary'} mx-1" data-page="${i}">${i}</button>`;
                    pagination.append(pageButton);
                } else if (i === current - 2 || i === current + 2) {
                    pagination.append('<span class="mx-1">...</span>');
                }
            }

            let nextButton = `<button class="btn btn-sm btn-secondary mx-1" data-page="${current + 1}" ${current === last ? 'disabled' : ''}>Next</button>`;
            pagination.append(nextButton);

            // Re-enable pagination buttons
            $('#pagination button').prop('disabled', false);
        },
        error: function (xhr, status, error) {
            console.error("Error loading courses: ", error);
            $('#pagination button').prop('disabled', false);  // Enable buttons on error
        }
    });
}

    </script>
@endsection

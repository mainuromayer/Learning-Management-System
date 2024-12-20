<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($courses as $course)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <!-- Display Course Image with fixed height and object-fit to cover -->
                            <img class="img-fluid" src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                style="height: 200px; width:100%; object-fit: cover;">

                            <!-- Read More and Join Now Buttons -->
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <!-- Read More Button -->
                                <a href="{{ route('course_details', $course->id) }}"
                                    class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end">
                                    Course Details
                                </a>

                                <!-- Enroll Now Button (Use form to send POST request) -->
                                <form action="{{ route('course_enroll', $course->id) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary px-3">
                                        Enroll Now
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="text-center p-4 pb-0">
                            <h3 class="mb-0">৳{{ number_format($course->price, 2) }}</h3>
                            <div class="mb-3">
                                <!-- Course Ratings -->
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>({{ $course->enrollments->count() }})</small>
                            </div>
                            <h5 class="mb-4">{{ $course->title }}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor->user->name ?? 'Instructor' }}
                            </small>
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-clock text-primary me-2"></i>{{ $course->duration ?? 0 }} Hrs
                            </small>
                            <small class="flex-fill text-center py-2">
                                <i class="fa fa-user text-primary me-2"></i>{{ $course->enrollments->count() }} Students
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $courses->links() }}
        </div>
    </div>
</div>
<!-- Courses End -->

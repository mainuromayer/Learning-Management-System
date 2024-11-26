<!-- Courses Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
            <h1 class="mb-5">Popular Courses</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($courses as $course)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <!-- Display Course Image with fixed height and object-fit to cover -->
                            <img class="img-fluid" src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" style="height: 200px; width:100%; object-fit: cover;">
  
                            <!-- Read More and Join Now Buttons -->
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="{{-- {{ route('course_details', ['course' => $course->id]) }} --}}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                                <a href="{{-- {{ route('course_enroll', ['course' => $course->id]) }} --}}" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Join Now</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <!-- Display Course Price -->
                            <h3 class="mb-0">৳{{ number_format($course->price, 2) }}</h3>
                            <div class="mb-3">
                                <!-- Display Course Ratings (For now, statically showing 5 stars) -->
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small>({{ $course->enrollments->count() }})</small>
                            </div>
                            <!-- Display Course Title -->
                            <h5 class="mb-4">{{ $course->title }}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <!-- Display Instructor Name -->
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-user-tie text-primary me-2"></i>{{ $course->instructor->user->name ?? 'Instructor' }}
                            </small>
                            <!-- Display Course Duration (Optional, add duration to the course model if needed) -->
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-clock text-primary me-2"></i>{{ $course->duration ?? 0 }} Hrs
                            </small>
                            <!-- Display Number of Enrolled Students -->
                            <small class="flex-fill text-center py-2">
                                <i class="fa fa-user text-primary me-2"></i>{{ $course->enrollments->count() }} Students
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
  
        <!-- Load More Button -->
        <div class="text-center my-5">
            <a class="btn btn-primary py-2 px-3 animated slideInDown" href="{{-- {{ route('courses_page') }} --}}">
                More
                <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                    <i class="fa fa-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
  </div>
  <!-- Courses End -->
  
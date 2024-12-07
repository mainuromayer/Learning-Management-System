<!-- Course Details Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    <div class="overflow-hidden">
                        <!-- Display Course Image -->
                        <img class="img-fluid" src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" style="height: 300px; width:100%; object-fit: cover;">
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="text-center text-md-start">
                    <!-- Course Title -->
                    <h1>{{ $course->title }}</h1>
                    
                    <!-- Course Description -->
                    <p><strong>Description: </strong>{{ $course->description ?? 'Course description not available' }}</p>
                    
                    <!-- Instructor Information -->
                    <p><strong>Instructor: </strong>{{ $course->instructor->user->name ?? 'Instructor Name Not Available' }}</p>
                    
                    <!-- Course Price -->
                    <p><strong>Price: </strong>৳{{ number_format($course->price, 2) }}</p>
                    
                    <!-- Course Duration -->
                    <p><strong>Duration: </strong>{{ $course->duration }} Hours</p>
  
                    <!-- Course Enrollment Info -->
                    <p><strong>Enrolled Students: </strong>{{ $course->enrollments->count() }} students</p>
                </div>
  
                <!-- Social Links (optional) -->
                <div class="mt-4">
                    <h5 class="mb-4">Social Links</h5>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        @if ($course->instructor->facebook)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $course->instructor->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if ($course->instructor->twitter)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $course->instructor->twitter }}"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if ($course->instructor->linkedin)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $course->instructor->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
  
        <!-- Back Button -->
        <div class="text-center my-5">
          <a class="btn btn-primary py-2 px-3" href="{{ route('courses_page') }}">
              Back to Courses
              <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                  <i class="fa fa-arrow-left"></i>
              </div>
          </a>
        </div>
    </div>
  </div>
  <!-- Course Details End -->
  
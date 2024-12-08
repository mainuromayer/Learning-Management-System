<!-- Course Enrollment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Course Info Section -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="course-item bg-light">
                    <div class="overflow-hidden">
                        <!-- Display Course Image -->
                        <img class="img-fluid" src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" style="height: 300px; width:100%; object-fit: cover;">
                    </div>
                </div>
            </div>

            <!-- Course Details Section -->
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

                <!-- Check if User is Already Enrolled -->
                @if (session('message'))
                    <div class="alert alert-info text-center">
                        {{ session('message') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Enrollment Button -->
                @if(auth()->check() && !session('message')) 
                    <form action="{{ route('course_enroll', $course->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary py-2 px-4 mt-3">
                            Enroll Now
                        </button>
                    </form>
                @else
                    <p class="mt-3">You must be logged in to enroll. <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Login</a></p>
                @endif
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
<!-- Course Enrollment End -->

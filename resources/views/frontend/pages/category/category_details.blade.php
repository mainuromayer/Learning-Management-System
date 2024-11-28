<!-- Category Details Start -->
<div class="container-xxl py-5">
  <div class="container">
      <h1>{{ $category->category_name }} - {{ $category->courses_count }} Courses</h1>
      <p>{{ $category->description ?? 'No description available.' }}</p>
      
      <div class="row g-3">
          @foreach ($category->courses as $course)
              <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                  <div class="course-item bg-light">
                      <img class="img-fluid" src="{{ asset($category->thumbnail) }}" alt="{{ $course->title }}">
                      <h5>{{ $course->title }}</h5>
                      <p>{{ $course->short_description }}</p>
                      <a href="{{ route('course.details', $course->id) }}" class="btn btn-primary">View Course</a>
                  </div>
              </div>
          @endforeach
      </div>
  </div>
</div>
<!-- Category Details End -->

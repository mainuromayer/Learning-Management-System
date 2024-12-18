<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        @foreach ($courses as $course)
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid carousel-image" src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" style="width: 100%; height: 500px; object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Best Online Courses</h5>
                            <h1 class="display-3 text-white animated slideInDown">{{ $course->title }}</h1>
                            <p class="fs-5 text-white mb-4 pb-2">{{ Str::limit($course->short_description, 150) }}</p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('course_details', $course->id) }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                            <form action="{{ route('course_enroll', $course->id) }}" method="POST"
                                class="">
                                @csrf
                                <button type="submit" class="btn btn-light py-md-3 px-md-5 animated slideInRight">
                                    Enroll Now
                                </button>
                            </form>
                            </div>
                            {{-- <a href="{{ route('course_enroll', $course->id) }}" class="">Join Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Carousel End -->

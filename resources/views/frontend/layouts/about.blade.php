<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left side: Dynamic Image -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" 
                      src="{{ $about_us->image ? asset('storage/' . $about_us->image) : asset('images/no_image.png') }}" 
                      alt="About Us Image" 
                      style="object-fit: cover;">
                </div>
            </div>
  
            <!-- Right side: Dynamic Content -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                <h1 class="mb-4">{{ $about_us->title ?? 'Welcome to LMS' }}</h1>
                <p class="mb-4">{{ $about_us->description ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' }}</p>
                <p class="mb-4">{{ $about_us->short_description ?? 'Additional description content goes here.' }}</p>
  
                <!-- Dynamic Points -->
                <div class="row gy-2 gx-4 mb-4">
                    @foreach(json_decode($about_us->points, true) as $point)
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>{{ $point }}</p>
                        </div>
                    @endforeach
                </div>
  
                <!-- Dynamic 'Read More' Link -->
                {{-- @if($about_us->read_more_link) --}}
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{-- {{ $about_us->read_more_link }} --}}">Read More</a>
                {{-- @endif --}}
            </div>
        </div>
    </div>
  </div>
  <!-- About End -->
  
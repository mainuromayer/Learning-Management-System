<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Side: Image -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item bg-light">
                    <div class="overflow-hidden">
                        <!-- Display About Us Image -->
                        <img class="img-fluid" src="{{ $about_us->image ? asset('storage/' . $about_us->image) : asset('frontend/img/about.jpg') }}" alt="About Us Image" style="object-fit: cover;">
                    </div>
                </div>
            </div>
 
            <!-- Right Side: Description and Points -->
            <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="text-center text-md-start">
                    <!-- Title -->
                    <h1 class="mb-4">{{ $about_us->title ?? 'Welcome to GUB' }}</h1>
                    <!-- Description -->
                    <p class="mb-4">{{ $about_us->description ?? 'Default description about GUB.' }}</p>
                    
                    <!-- List of Points -->
                    <div class="row gy-2 gx-4 mb-4">
                        @if($about_us->points)
                            @foreach(json_decode($about_us->points, true) as $point)
                                <div class="col-sm-6">
                                    <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>{{ $point }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
 
                    <!-- Address, Phone, Email -->
                    <div class="mb-4">
                        <p><strong>Address:</strong> {{ $about_us->address ?? 'Not available' }}</p>
                        <p><strong>Phone:</strong> {{ $about_us->phone ?? 'Not available' }}</p>
                        <p><strong>Email:</strong> {{ $about_us->email ?? 'Not available' }}</p>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="d-flex justify-content-center justify-content-md-start">
                        @if($about_us->facebook)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $about_us->facebook }}"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($about_us->twitter)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $about_us->twitter }}"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if($about_us->youtube)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $about_us->youtube}}"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if($about_us->linkedin)
                            <a class="btn btn-sm-square btn-primary mx-1" href="{{ $about_us->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
 
        <!-- Gallery -->
        <div class="row g-2 pt-4">
            @if($about_us->gallery)
                @foreach(json_decode($about_us->gallery, true) as $image)
                    <div class="col-4">
                        <!-- Use inline CSS for styling images -->
                        <img class="img-fluid" src="{{ asset('storage/' . $image) }}" alt="Gallery Image" style="width: 100%; height: 250px; object-fit: cover;">
                    </div>
                @endforeach
            @endif
        </div>
        
        
    </div>
 
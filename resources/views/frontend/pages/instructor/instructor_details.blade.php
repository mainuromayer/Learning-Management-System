<!-- Instructor Details Start -->
<div class="container-xxl py-5">
  <div class="container">
      
      <div class="row g-4">
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="team-item bg-light">
                  <div class="overflow-hidden">
                      <img class="img-fluid" src="{{ $instructor->user_image ? asset($instructor->user_image) : asset('images/no_image.png') }}" alt="Instructor Image">
                  </div>
              </div>
          </div>
          <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="text-center text-md-start">
                {{-- <h1>{{ $instructor->user->name ?? 'Instructor Name' }}</h1> --}}
                
                  <p><strong>Name: </strong>{{ $instructor->user->name ?? 'Instructor Name Not Available' }}</p>
                  <p><strong>Biography: </strong>{{ $instructor->biography ?? 'Instructor Biography Not Available' }}</p>
                  <p><strong>Email: </strong>{{ $instructor->user->email ?? 'Instructor Email Not Available' }}</p>
                  <p><strong>Phone: </strong>{{ $instructor->phone ?? 'Instructor Phone Not Available' }}</p>
                  
              </div>

              <div class="mt-4">
                  <h5 class="mb-4">Social Links</h5>
                  <div class="d-flex justify-content-center justify-content-md-start">
                      @if ($instructor->facebook)
                          <a class="btn btn-sm-square btn-primary mx-1" href="{{ $instructor->facebook }}"><i class="fab fa-facebook-f"></i></a>
                      @endif
                      @if ($instructor->twitter)
                          <a class="btn btn-sm-square btn-primary mx-1" href="{{ $instructor->twitter }}"><i class="fab fa-twitter"></i></a>
                      @endif
                      @if ($instructor->linkedin)
                          <a class="btn btn-sm-square btn-primary mx-1" href="{{ $instructor->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                      @endif
                  </div>
              </div>
          </div>
      </div>

      <!-- Back Button -->
      <div class="text-center my-5">
        <a class="btn btn-primary py-2 px-3" href="{{ route('instructor_page') }}">
            Back to Instructors
            <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                <i class="fa fa-arrow-left"></i>
            </div>
        </a>
      </div>
  </div>
</div>
<!-- Instructor Details End -->

<!-- Instructor Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Instructors</h6>
            <h1 class="mb-5">Expert Instructors</h1>
        </div>
        <div class="row g-4">
            @foreach ($instructors as $instructor)
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 + 0.1 }}s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden">
                            <!-- Inline style to fix the image height -->
                            <img class="img-fluid" src="{{ $instructor->user_image ? asset($instructor->user_image) : asset('images/no_image.png') }}" alt=""
                                 style="height: 200px; width: 100%; object-fit: cover;">
                        </div>
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                            <div class="bg-light d-flex justify-content-center pt-2 px-1">
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
                        <div class="text-center p-4">
                            <h5 class="mb-0">
                                {{ $instructor->user->name ?? 'Instructor Name Not Available' }}
                            </h5>
                            <small class="fw-bold">
                                {{ $instructor->user->email ?? 'Instructor Email Not Available' }}
                            </small><br>
                            <small>
                              {{ $instructor->phone ?? 'Instructor Phone Not Available' }}
                            </small><br><br>
                            <a class="text-uppercase" href="{{ route('instructor_details', $instructor->id) }}">Read More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
  
        <!-- Load More Button -->
        <div class="text-center my-5">
          <a class="btn btn-primary py-2 px-3 animated slideInDown" href="{{-- {{ route('instructor_page') }} --}}">
              More
              <div class="d-inline-flex btn-sm-square bg-white text-primary rounded-circle ms-2">
                  <i class="fa fa-arrow-right"></i>
              </div>
          </a>
      </div>
    </div>
  </div>
  <!-- Instructor End -->
  
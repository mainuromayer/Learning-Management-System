<!-- Instructor Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Instructor list Start -->
            <div class="col-lg-12">
                <div class="row g-4">
                    @foreach ($instructors as $instructor)
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 + 0.1 }}s">
                            <div class="team-item bg-light">
                                <div class="overflow-hidden">
                                    <img class="img-fluid"
                                        src="{{ $instructor->user_image ? asset($instructor->user_image) : asset('images/no_image.png') }}"
                                        alt="">
                                </div>
                                <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                                    <div class="bg-light d-flex justify-content-center pt-2 px-1">
                                        @if ($instructor->facebook)
                                            <a class="btn btn-sm-square btn-primary mx-1"
                                                href="{{ $instructor->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if ($instructor->twitter)
                                            <a class="btn btn-sm-square btn-primary mx-1"
                                                href="{{ $instructor->twitter }}"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if ($instructor->linkedin)
                                            <a class="btn btn-sm-square btn-primary mx-1"
                                                href="{{ $instructor->linkedin }}"><i
                                                    class="fab fa-linkedin-in"></i></a>
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
                                        {{ $instructor->phone ?? 'Instructor Email Not Available' }}
                                    </small><br><br>
                                    <a class="text-uppercase"
                                        href="{{ route('instructor_details', $instructor->id) }}">Read More <i
                                            class="bi bi-arrow-right"></i></a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="col-12 text-center mt-5">
                    <!-- This will render the pagination links -->
                    {{ $instructors->links('vendor.pagination.bootstrap-4') }}
                </div>

            </div>
            <!-- Instructor list End -->
        </div>
    </div>
</div>
<!-- Instructor End -->

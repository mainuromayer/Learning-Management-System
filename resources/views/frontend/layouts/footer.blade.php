<!-- Footer Start -->
<div id="contact" class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                <a class="btn btn-link" href="{{ route('about_page') }}">About Us</a>
                <a class="btn btn-link" href="javascript:void(0);">Contact Us</a>
                <a class="btn btn-link" href="javascript:void(0);">Privacy Policy</a>
                <a class="btn btn-link" href="javascript:void(0);">Terms & Condition</a>
                <a class="btn btn-link" href="javascript:void(0);">FAQs & Help</a>
            </div>
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Contact</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $about_us->address ?? 'Dhaka, Bangladesh' }}</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ $about_us->phone ?? 'Not available' }}</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $about_us->email ?? 'Not available' }}</p>
                <div class="d-flex pt-2">
                    @if($about_us->facebook)
                        <a class="btn btn-outline-light btn-social" href="{{ $about_us->facebook }}"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if($about_us->twitter)
                        <a class="btn btn-outline-light btn-social" href="{{ $about_us->twitter }}"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if($about_us->youtube)
                        <a class="btn btn-outline-light btn-social" href="{{ $about_us->youtube }}"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if($about_us->linkedin)
                        <a class="btn btn-outline-light btn-social" href="{{ $about_us->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Gallery</h4>
                <div class="row g-2 pt-2">
                    @foreach(array_slice(json_decode($about_us->gallery, true), 0, 6) as $image)
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="{{ asset('storage/' . $image) }}" alt="Gallery Image" style="width:100%; height: 50px; object-fit: cover;">

                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Newsletter</h4>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-12 text-center mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="javascript:void(0);">GUB</a>, All Right Reserved.
                    {{-- Designed By <a class="border-bottom" href="https://codefotech.com/">CodeFoTech --}}</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
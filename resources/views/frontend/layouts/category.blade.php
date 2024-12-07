<!-- Categories Start -->
<div class="container-xxl py-5 category">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
            <h1 class="mb-5">Courses Categories</h1>
        </div>
        <div class="row g-3">
            <!-- First Column (Full Width for MD and Large Devices) -->
            <div class="col-lg-6 col-md-6 col-12 wow zoomIn" data-wow-delay="0.1s">
                @if (!empty($categories[0]))
                    <a class="position-relative d-block overflow-hidden"
                        href="{{ route('category.details', $categories[0]->id) }}">
                        <img class="img-fluid" src="{{ asset($categories[0]->thumbnail ?? 'images/no_image.png') }}"
                            style="height: 100%; width: 100%;" alt="{{ $categories[0]->category_name }}">
                        <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                            style="margin: 1px;">
                            <h5 class="m-0">{{ $categories[0]->category_name }}</h5>
                            <small class="text-primary">{{ $categories[0]->courses_count }} Courses</small>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Second Column -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="row g-3">
                    <!-- First Row (First Half for Medium Screens) -->
                    @if (!empty($categories[1]))
                        <div class="col-lg-12 col-md-12 col-12 wow zoomIn" data-wow-delay="0.2s">
                            <a class="position-relative d-block overflow-hidden"
                                href="{{ route('category.details', $categories[1]->id) }}">
                                <img class="img-fluid"
                                    src="{{ asset($categories[1]->thumbnail ?? 'images/no_image.png') }}"
                                    style="height: 250px; width: 100%;" alt="{{ $categories[1]->category_name }}">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                    style="margin: 1px;">
                                    <h5 class="m-0">{{ $categories[1]->category_name }}</h5>
                                    <small class="text-primary">{{ $categories[1]->courses_count }} Courses</small>
                                </div>
                            </a>
                        </div>
                    @endif

                    <!-- Second Row (Second Half for Medium Screens) -->
                    @if (!empty($categories[2]))
                        <!-- First Row (First Half for Medium Screens) -->
                        @if (!empty($categories[1]))
                            <div class="col-lg-12 col-md-12 col-12 wow zoomIn" data-wow-delay="0.2s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('category.details', $categories[1]->id) }}">
                                    <img class="img-fluid"
                                        src="{{ asset($categories[1]->thumbnail ?? 'images/no_image.png') }}"
                                        style="height: 250px; width: 100%;" alt="{{ $categories[1]->category_name }}">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[1]->category_name }}</h5>
                                        <small class="text-primary">{{ $categories[1]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif

                        <!-- Second Row (Second Half for Medium Screens) -->
                        @if (!empty($categories[2]))
                            <div class="col-lg-12 col-md-6 col-6 wow zoomIn" data-wow-delay="0.3s">
                                <a class="position-relative d-block overflow-hidden"
                                    href="{{ route('category.details', $categories[2]->id) }}">
                                    <img class="img-fluid"
                                        src="{{ asset($categories[2]->thumbnail ?? 'images/no_image.png') }}"
                                        style="height: 250px; width: 100%;" alt="{{ $categories[2]->category_name }}">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3"
                                        style="margin: 1px;">
                                        <h5 class="m-0">{{ $categories[2]->category_name }}</h5>
                                        <small class="text-primary">{{ $categories[2]->courses_count }} Courses</small>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Read More Button -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('category_page') }}" class="btn btn-primary"> More &nbsp;<i
                        class="fa fa-arrow-right text-sm"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- Categories End -->

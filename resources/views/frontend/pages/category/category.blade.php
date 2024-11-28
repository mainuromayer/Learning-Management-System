<!-- Categories Section Start -->
<div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container py-5">
      <div class="row g-5">
          <!-- Categories list Start -->
          <div class="col-lg-12">
              <div class="row g-4">
                  @foreach ($categories as $category)
                      <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->index * 0.2 + 0.1 }}s">
                          <div class="team-item bg-light">
                              <div class="overflow-hidden">
                                  <!-- Display category image -->
                                  <img class="img-fluid" src="{{ asset($category->thumbnail) }}" alt="{{ $category->category_name }}"
                                      style="height: 200px; width: 100%; object-fit: cover;">
                              </div>
                              <div class="text-center p-4">
                                  <h5 class="mb-0">
                                      {{ $category->category_name }}
                                  </h5>
                                  <small class="fw-bold">
                                      {{ $category->courses_count }} Courses
                                  </small><br><br>
                                  <a class="text-uppercase"
                                      href="{{ route('category.details', $category->id) }}">View Courses <i
                                          class="bi bi-arrow-right"></i></a>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>

              <!-- Pagination -->
              <div class="col-12 text-center mt-5">
                  <!-- This will render the pagination links -->
                  {{ $categories->links('vendor.pagination.bootstrap-4') }}
              </div>

          </div>
          <!-- Categories list End -->
      </div>
  </div>
</div>
<!-- Categories Section End -->

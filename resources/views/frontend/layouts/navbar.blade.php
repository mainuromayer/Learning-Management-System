<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
  <a href="" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
      <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>LMS</h2>
  </a>
  <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
          <a href="{{ route('home') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" class="nav-item nav-link active">Home</a>
          <a href="{{ route('instructor_page') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'instructor_page' ? 'active' : '' }}" class="nav-item nav-link active">Instructor</a>
          <a href="{{ route('about_page') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'about_page' ? 'active' : '' }}">About</a>
          <a href="{{ route('courses_page') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'courses_page' ? 'active' : '' }}">Courses</a>
          <div class="nav-item dropdown">
              <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
              <div class="dropdown-menu fade-down m-0">
                  <a href="javascript:void(0);" class="dropdown-item">Our Team</a>
                  <a href="javascript:void(0);" class="dropdown-item">Testimonial</a>
                  <a href="javascript:void(0);" class="dropdown-item">404 Page</a>
              </div>
          </div>
          <a href="javascript:void(0);" class="nav-item nav-link">Contact</a>
      </div>



      <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login Now<i class="fa fa-arrow-right ms-3"></i></a>




  </div>
</nav>
<!-- Navbar End -->
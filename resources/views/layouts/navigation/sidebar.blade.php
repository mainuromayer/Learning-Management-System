<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
{{--        <a href="javascript:void(0);" class="app-brand-link">--}}
{{--            <img src="{{ asset('assets/img/icons/logo.png') }}" alt="" width="100%">--}}
{{--        </a>--}}
        <a href="" class="navbar-brand">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>LMS</h2>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        

        <!-- Admin-specific menu items -->
        @if(Auth::user() && Auth::user()->role->slug === 'admin')
<!-- Dashboards -->
<li class="menu-item {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class="menu-link ">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboards">Dashboards</div>
    </a>
</li>

<!-- AboutUs -->
@can('user')
<li class="menu-item {{ Request::is('category') || Request::is('category/*') ? 'active' : '' }}">
    <a href="{{ route('about_us.showForm') }}" class="menu-link ">
        <i class="menu-icon tf-icons bx bx-category-alt"></i>
        <div data-i18n="AboutUs">AboutUs</div>
    </a>
</li>
@endcan

            <!-- Category -->
            @can('category')
                <li class="menu-item {{ Request::is('category') || Request::is('category/*') ? 'active' : '' }}">
                    <a href="{{ route('category.list') }}" class="menu-link ">
                        <i class="menu-icon tf-icons bx bx-category-alt"></i>
                        <div data-i18n="Category">Category</div>
                    </a>
                </li>
            @endcan

            <!-- Course -->
            @can('course')
                <li class="menu-item {{ Request::is('course') || Request::is('course/*') ? 'active' : '' }}">
                    <a href="{{ route('course.list') }}" class="menu-link ">
                        <i class="menu-icon tf-icons bx bx-folder-open"></i>
                        <div data-i18n="Course">Course</div>
                    </a>
                </li>
            @endcan

            <!-- Enroll Student -->
            @can('user')
                <li class="menu-item {{ Request::is('enroll_student') || Request::is('enroll_student/*') ? 'active' : '' }}">
                    <a href="{{ route('enroll_student.list') }}" class="menu-link ">
                        <i class="menu-icon tf-icons bx bx-log-in-circle"></i>
                        <div data-i18n="EnrollStudent">Enroll Student</div>
                    </a>
                </li>
            @endcan

            <!-- User management -->
            @can('user')
            <li class="menu-item {{ Request::is('users') || Request::is('users/*') ? 'active' : '' }} {{ Request::segment(1)== 'users' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div data-i18n="User">Users</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::segment(2)== 'user' ? 'active' : '' }}">
                        <a href="{{ route('user.list') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-user fa-fw"></i>
                            <div>Admin User</div>
                        </a>
                    </li>

                    <li class="menu-item {{ Request::segment(2)== 'instructor' ? 'active' : '' }}">
                        <a href="{{ route('instructor.list') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-user fa-fw"></i>
                            <div>Instructor</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::segment(2)== 'student' ? 'active' : '' }}">
                        <a href="{{ route('student.list') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-user fa-fw"></i>
                            <div>Student</div>
                        </a>
                    </li>

                </ul>
            </li>
            @endcan

            <!-- Settings -->
            @can('user-permission')
            <li class="menu-item {{ Request::is('settings') || Request::is('settings/*') ? 'active' : '' }} {{ Request::segment(1)== 'settings' ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Dashboards">Settings</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::segment(2)== 'user-permission' ? 'active' : '' }}">
                        <a href="{{ route('user-permission') }}" class="menu-link">
                            <i class="menu-icon tf-icons fas fa-user-lock fa-fw"></i>
                            <div>User Permission</div>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
        @endif

        <!-- Instructor-specific menu items -->
        @if(Auth::user() && Auth::user()->role->slug === 'instructor')
            <!-- Instructor-specific links can go here -->
            <!-- For example: -->
            <li class="menu-item {{ Request::is('course') || Request::is('course/*') ? 'active' : '' }}">
                <a href="{{ route('course.list') }}" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-folder-open"></i>
                    <div data-i18n="Course">My Courses</div>
                </a>
            </li>
        @endif

        <!-- Student-specific menu items -->
        @if(Auth::user() && Auth::user()->role->slug === 'student')
            <!-- Student-specific links can go here -->
            <!-- Dashboards -->
            <li class="menu-item {{ Request::is('dashboard') || Request::is('dashboard/*') ? 'active' : '' }}">
                <a href="{{ route('student.dashboard') }}" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                </a>
            </li>

            {{-- <!-- For example: -->
            <li class="menu-item {{ Request::is('my-courses') || Request::is('my-courses/*') ? 'active' : '' }}">
                <a href="{{ route('student.courses') }}" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="My Courses">My Courses</div>
                </a>
            </li> --}}
        @endif

    </ul>
</aside>

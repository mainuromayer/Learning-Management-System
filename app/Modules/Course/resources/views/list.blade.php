@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">List Course</h3>
                    <div class="card-tools">
                        <a href="{{ route('quiz.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Quiz
                        </a>
                        <a href="{{ route('lesson.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Lesson
                        </a>
                        <a href="{{ route('section.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Section
                        </a>
                        <a href="{{ route('assignment.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Assignment
                        </a>
                        <a href="{{ route('course.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Course
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Instructor Name</th>
                                <th>Instructor Email</th>
                                <th>Category</th>
                                <th>Enrolled Student</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable_js')

    <script>
        $(function() {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('course.list') }}",
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'instructor_name', name: 'instructor_name' },
                    { data: 'instructor_email', name: 'instructor_email' },
                    { data: 'category', name: 'category' },
                    { data: 'enrolled_student', name: 'enrolled_student' },
                    { data: 'status', name: 'status' },
                    { data: 'price', name: 'price' },
                    { data: 'action', name: 'action' }
                ],
                "sorting": []
            });
        });
    </script>
@endsection

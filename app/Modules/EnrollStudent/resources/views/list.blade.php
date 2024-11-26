@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">Enrollments List</h3>
                    <div class="card-tools">
                        <a href="{{ route('enroll_student.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Enrollment
                        </a>
                    </div>
                </div>

                <div class="card-body mt-4">
                    <table id="enrollments-table" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course Title</th>
                                <th>Enrollment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable_js')

    <script>
        $(function () {
            $('#enrollments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('enroll_student.list') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'course_title', name: 'course_title' },
                    { data: 'enrollment_date', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
    
@endsection

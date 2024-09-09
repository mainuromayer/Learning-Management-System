
@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"><i class="fa fa-list"></i> Student List</h3>
                    <div class="card-tools">
                        <a href="{{ route('student.create') }}" class="btn btn-primary">Add Student</a>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    {{-- <th>Course ID</th> --}}
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th> Number Of Course </th> 
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div><!-- /.panel -->

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
                    url: "{{ route('student.list') }}",
                    method: 'post',
                    data: function(d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [{
                   
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: '',
                        name: ''
                    },
                   
                    
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "Sorting": []
            });
        });
    </script>
@endsection

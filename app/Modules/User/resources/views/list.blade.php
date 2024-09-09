@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2"> Admin User List </h3>
                    <div class="card-tools">
                        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add User
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Last Updated</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->

        </div>
    </div>
@endsection

@section('footer-script')

    @include('partials.datatable_js')

    <script>
        $(function () {
            $('#list').DataTable({
                processing: true,
                serverSide: true,
                "ordering": true,
                ajax: {
                    url: '{{ route('user.list') }}',
                    method: 'post',
                    data: function (d) {
                        d._token = $('input[name="_token"]').val();
                    }
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "aaSorting": []
            });
        });
    </script>
@endsection

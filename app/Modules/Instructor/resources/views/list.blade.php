
@extends('layouts.admin')

@section('header-resources')
@include('partials.datatable_css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 p-5 pt-3">

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title pt-2 pb-2">List Instructor</h3>
                <div class="card-tools">
                    <a href="{{ route('instructor.create') }}" class="btn btn-sm btn-primary">
                        <i class="bx bx-plus pr-2"></i> Add Instructor
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="list" class="table table-striped table-bordered dt-responsive " cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th> # </th>{{-- id --}}
                            <th> Name </th>{{-- name, email --}}
                            <th> Phone </th>{{-- phone --}}
                            <th> Number Of Course </th>{{-- course:(count) --}}
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
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
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'short_description',
                    name: 'short_description'
                },

                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'create_as',
                    name: 'create_as'
                },

                {
                    data: 'category',
                    name: 'category'
                },
                {
                    data: 'course_level',
                    name: 'course_level'
                },
                {
                    data: 'pricing_type',
                    name: 'pricing_type'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'discounted_price',
                    name: 'discounted_price'
                },
                {
                    data: 'thumbnail',
                    name: 'thumbnail'
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

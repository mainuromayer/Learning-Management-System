@extends('layouts.admin')

@section('header-resources')
    @include('partials.datatable_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-5 pt-3">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title pt-2 pb-2">List Category</h3>
                    <div class="card-tools">
                        <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus pr-2"></i> Add Category
                        </a>
                    </div>
                </div>

                <div class="card-body mt-4">
                    <div class="row" id="category-grid">
                        <!-- Categories will be dynamically loaded here -->
                    </div>
                    <div id="pagination" class="mt-3">
                        <!-- Pagination controls will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    @include('partials.datatable_js')

    <script>
        $(function () {
            let currentPage = 1;

            function loadCategories(page) {
                $.ajax({
                    url: "{{ route('category.list') }}",
                    method: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        page: page
                    },
                    success: function (data) {
                        let categories = data.data;
                        let categoryGrid = $('#category-grid');
                        let pagination = $('#pagination');
                        categoryGrid.empty();
                        pagination.empty();

                        categories.forEach(function (category) {
                            let thumbnail = category.thumbnail ? category.thumbnail : "{{ asset('images/no_image.png') }}";
                            let description = category.description ? category.description : 'No description available'; // Fallback if description is null

                            description = description.length > 100 ? description.substring(0, 100) + '...' : description;

                            let keywords = category.keywords ? JSON.parse(category.keywords) : [];

                            let keywordsHtml = keywords.length > 0
                                ? keywords.map(keyword => `<span class="p-1 mx-1 small bg-primary text-white rounded mr-1">${keyword}</span>`).join('')
                                : '<span class="p-1 mx-1 small bg-secondary text-white rounded">No keywords available</span>';

                            let categoryHtml = `
                            <div class="col-md-4 mb-4">
                                <div class="card" style="height: 100%;">
                                    <img src="${thumbnail}" alt="${category.category_name}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column" style="height: 100%;">
                                        <h5 class="card-title py-3">${category.category_name}</h5>
                                        <div class="mb-3">Keywords:
                                            ${keywordsHtml}
                                        </div>
                                        <p class="card-text text-muted flex-grow-1">${description}</p>
                                        <a href="/category/edit/${category.id}" class="btn btn-primary btn-sm"><i class="bx bx-edit"></i></a>
                                    </div>
                                </div>
                            </div>
                        `;
                            categoryGrid.append(categoryHtml);
                        });

                        const total = data.pagination.total;
                        const current = data.pagination.current_page;
                        const last = data.pagination.last_page;

                        // Create Previous Button
                        let prevButton = `<button class="btn btn-sm btn-secondary mx-1" data-page="${current - 1}" ${current === 1 ? 'disabled' : ''}>Prev</button>`;
                        pagination.append(prevButton);

                        // Numbered pages logic (similar to before)
                        for (let i = 1; i <= last; i++) {
                            if (i === 1 || i === last || (i >= current - 1 && i <= current + 1)) {
                                let pageButton = `<button class="btn btn-sm ${i === current ? 'btn-primary' : 'btn-secondary'} mx-1" data-page="${i}">${i}</button>`;
                                pagination.append(pageButton);
                            } else if (i === current - 2 || i === current + 2) {
                                pagination.append('<span class="mx-1">...</span>');
                            }
                        }

                        // Create Next Button
                        let nextButton = `<button class="btn btn-sm btn-secondary mx-1" data-page="${current + 1}" ${current === last ? 'disabled' : ''}>Next</button>`;
                        pagination.append(nextButton);

                        // Attach click event to pagination buttons
                        $('#pagination button').on('click', function () {
                            let page = $(this).data('page');
                            if (!$(this).attr('disabled')) { // Ensure we don't process clicks on disabled buttons
                                loadCategories(page);
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error loading categories: ", error);
                    }
                });
            }

            // Initial load
            loadCategories(currentPage);
        });
    </script>
@endsection


@if (session()->has('success'))
    <div class="row">
        <div class="col-lg-12 p-5 pt-3 pb-2">
            <div class="alert alert-success alert-dismissible" role="alert">
                     {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="row">
        <div class="col-lg-12 p-5 pt-3 pb-2">
            <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

@extends('layouts-admin.app')
@section('title', 'RACE NET | Manage Service Detail')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Manage Service Detail </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('manage-service.index') }}">Manage Service Detail</a></li>
                <li class="breadcrumb-item active">Edit Manage Service Detail</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <h5 class="card-title">Form Edit Manage Service Detail</h5>

                        <!-- General Form Elements -->

                        <form action="{{ route('manage-service-detail.update', $manage_service_detail->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" required value="{{ $manage_service_detail->title }}">
                                                <input type="text" name="category" class="form-control" required value="{{ $manage_service_detail->category }}" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Code Icon</label>
                                                <input type="text" name="link" class="form-control" required value="{{ $manage_service_detail->link }}">
                                                <a href="https://icons.getbootstrap.com/" target="_blank" class="link-icon">Click here for view icon!!</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="desc" rows="5" required>{{ $manage_service_detail->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="text-center mt-3 mb-2">
                        <button type="submit" class="btn btn-primary">Submit Form</button>
                    </div>

                    </form><!-- End General Form Elements -->

                </div>
            </div>
        </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection

@push('scripts')
<script>
</script>
@endpush
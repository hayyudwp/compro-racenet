@extends('layouts-admin.app')
@section('title', 'RACE NET | Broadband Internet')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Broadband Internet</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('broadband.index') }}">Broadband Internet</a></li>
                <li class="breadcrumb-item active">New Broadband Internet</li>
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
                        <h5 class="card-title">Form New Broadband Internet</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('broadband.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" required>
                                                <input type="text" name="category" class="form-control" value="broadband" hidden>
                                            </div>
                                        </div>
                                            
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">File Upload</label>
                                                <input type="file" name="image" id="upload_image" accept="image/png, image/gif, image/jpeg" class="form-control" required>
                                                <!-- <span style="font-size: 12px; color: gray; margin: 0 !important;">size : 1:1 </span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="desc" rows="5" required></textarea>
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
    $('input[name="image"]').change(function() {
        console.log('tes')
        var maxSizeBytes = 2 * 1024 * 1024;
        var fileSize = this.files[0].size;
        if (fileSize > maxSizeBytes) {
            $(this).val('');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "File size exceeds the maximum allowed size of 2MB!",
            });
        }
    });

</script>
@endpush
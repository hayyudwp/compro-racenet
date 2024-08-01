@extends('layouts-admin.app')
@section('title', 'Body-Soul | General')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>General</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('general.index') }}">General</a></li>
                <li class="breadcrumb-item active">Edit General</li>
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
                        <h5 class="card-title">Form Edit General</h5>

                        <!-- General Form Elements -->

                        <form action="{{ route('general.update',$general->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Parameter</label>
                                        <input type="text" name="params" class="form-control" required value="{{ $general->params }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Value</label>
                                        <input type="text" name="value" class="form-control" value="{{ $general->value }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            File Upload
                                            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#showimage">
                                                <i class="bi bi-eye-fill"></i>
                                            </button></label>
                                        <input type="file" name="value_file" class="form-control mb-2">
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

<div class="modal fade" id="showimage" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$general->value_file}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="{{ asset('storage/general') }}/{{$general->value_file}}" target="_blank">File Upload Link</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('input[name="value_file"]').change(function() {
        console.log('tes')
        var maxSizeBytes = 5 * 1024 * 1024;
        var fileSize = this.files[0].size;
        if (fileSize > maxSizeBytes) {
            $(this).val('');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "File size exceeds the maximum allowed size of 5MB!",
            });
        }
    });
</script>
@endpush
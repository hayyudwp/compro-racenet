@extends('layouts-admin.app')
@section('title', 'RACE NET | Dedicated Internet')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dedicated Internet </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dedicated.index') }}">Dedicated Internet</a></li>
                <li class="breadcrumb-item active">Edit Dedicated Internet</li>
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
                        <h5 class="card-title">Form Edit Dedicated Internet</h5>

                        <!-- General Form Elements -->

                        <form action="{{ route('dedicated.update',$dedicated->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" required value="{{ $dedicated->title }}">
                                                <input type="text" name="category" class="form-control" required value="{{ $dedicated->category }}" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    File Upload
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#showimage">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></label>
                                                <input type="file" name="image" class="form-control mb-2" style="margin: 0 !important;">
                                                <!-- <span style="font-size: 12px; color: gray; margin: 0 !important;">size : 1512 x 615 px</span> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="desc" rows="5" required>{{ $dedicated->desc }}</textarea>
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
                <h5 class="modal-title">{{$dedicated->image}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/product/dedicated') }}/{{$dedicated->image}}" width="100%">
            </div>
        </div>
    </div>
</div>

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
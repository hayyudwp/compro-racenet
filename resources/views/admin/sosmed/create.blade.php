@extends('layouts-admin.app')
@section('title', 'RACE NET | Social Media')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Social Media</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sosmed.index') }}">Social Media</a></li>
                <li class="breadcrumb-item active">New Social Media</li>
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
                        <h5 class="card-title">Form New Social Media</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('sosmed.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Icon</label>
                                                <input type="text" name="code_icon" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Link / URL</label>
                                        <input type="text" name="link" class="form-control" required>
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
    ClassicEditor
            .create(document.querySelector('#answer-editor'))
            .catch(error => {
                console.error(error);
            });

</script>
@endpush
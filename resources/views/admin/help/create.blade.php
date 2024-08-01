@extends('layouts-admin.app')
@section('title', 'RACE NET | Help')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Help</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('help.index') }}">Help</a></li>
                <li class="breadcrumb-item active">New Help</li>
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
                        <h5 class="card-title">Form New Help</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('help.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Question</label>
                                        <input type="text" name="question" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="" disabled selected hidden>-- Select --</option>
                                            <option value="panduan">Panduan</option>
                                            <option value="faq">FAQ</option>
                                            <option value="pembayaran">Metode Pembayaran</option>
                                            <option value="troubleshoot">Troubleshoot</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Answer</label>
                                        <textarea class="form-control tinymce" name="answer" rows="5"></textarea>
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
  tinymce.init({
            selector: 'textarea',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            menubar: false
        });
</script>
@endpush
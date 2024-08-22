@extends('layouts-admin.app')
@section('title', 'RACE NET | Help')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Help</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('help.index') }}">Help</a></li>
                <li class="breadcrumb-item active">Edit Help</li>
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
                        <h5 class="card-title">Form Edit Help</h5>

                        <!-- General Form Elements -->

                        <form action="{{ route('help.update',$help->id) }}" id="helpForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Question</label>
                                                <input type="text" name="question" class="form-control" required value="{{ $help->question }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="" disabled selected hidden>-- Select --</option>
                                                    <option value="panduan" {{ $help->category == 'panduan' ? 'selected' : '' }}>Panduan</option>
                                                    <option value="faq" {{ $help->category == 'faq' ? 'selected' : '' }}>FAQ</option>
                                                    <option value="pembayaran" {{ $help->category == 'pembayaran' ? 'selected' : '' }}>Metode Pembayaran</option>
                                                    <option value="troubleshoot" {{ $help->category == 'troubleshoot' ? 'selected' : '' }}>Troubleshoot</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Answer</label>
                                                <textarea class="form-control tinymce" name="answer" rows="5" >{{ $help->answer }}</textarea>
                                            </div>
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
                <h5 class="modal-title">{{$help->image}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('storage/helpbs') }}/{{$help->image}}" width="100%">
            </div>
        </div>
    </div>
</div>

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
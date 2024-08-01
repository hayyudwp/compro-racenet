@extends('layouts-admin.app')
@section('title', 'RACE NET | Price List')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Price List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pricelist.index') }}">Price List</a></li>
                <li class="breadcrumb-item active">New Price List</li>
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
                        <h5 class="card-title">Form New Price List</h5>

                        <!-- General Form Elements -->
                        <form action="{{ route('pricelist.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Paket</label>
                                                <input type="text" name="title" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Bandwith</label>
                                                <input type="text" name="bandwith" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Harga</label>
                                                <input type="text" name="price" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="" disabled hidden selected>- Pilih Kategori -</option>
                                                    <option value="home">Home</option>
                                                    <option value="sekolah">Sekolah/Yayasan</option>
                                                    <option value="perusahaan">Perusahaan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="tinymce" name="desc" rows="5"></textarea>

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
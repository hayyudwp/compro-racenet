@extends('layouts-admin.app')
@section('title', 'Body-Soul | Price List')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Price List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pricelist.index') }}">Price List</a></li>
                <li class="breadcrumb-item active">Edit Price List</li>
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
                        <h5 class="card-title">Form Edit Price List</h5>

                        <!-- General Form Elements -->


                        <form action="{{ route('pricelist.update', $pricelist->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Paket</label>
                                                <input type="text" name="title" class="form-control" required value="{{ old('title', $pricelist->title) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Bandwith</label>
                                                <input type="text" name="bandwith" class="form-control" required value="{{ old('bandwith', $pricelist->bandwith) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Harga</label>
                                                <input type="number" name="price" class="form-control" required value="{{ old('price', $pricelist->price) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select name="category" id="category" class="form-control">
                                                    <!-- <option value="" disabled hidden selected>- Pilih Kategori -</option> -->
                                                    <option value="home" {{ old('category', $pricelist->category) == 'home' ? 'selected' : '' }}>Home</option>
                                                    <option value="sekolah" {{ old('category', $pricelist->category) == 'sekolah' ? 'selected' : '' }}>Sekolah/Yayasan</option>
                                                    <option value="perusahaan" {{ old('category', $pricelist->category) == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control tinymce" name="desc" rows="5">{{ old('desc', $pricelist->desc) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3 mb-2">
                                <button type="submit" class="btn btn-primary">Submit Form</button>
                            </div>
                        </form>
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
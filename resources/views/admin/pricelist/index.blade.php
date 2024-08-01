@extends('layouts-admin.app')
@section('title', 'RACE NET | Price List')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Price List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Price List</li>
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
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title">Price List</h5>
                            <div class="py-3">
                                <a href="{{ route('pricelist.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> New Price List
                                </a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->

                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket</th>
                                        <th>Bandwith</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@endsection



@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    // Inisialisasi DataTables
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        language: {
            processing: "<div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>",
        },
        ajax: "{{ route('pricelist.index') }}",
        columns: [
            { data: null, name: 'number', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'bandwith', name: 'bandwith' },
            { data: 'price', name: 'price' },
            { data: 'desc', name: 'desc' },
            { data: 'category', name: 'category' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        createdRow: function(row, data, dataIndex) {
             // Mengisi kolom nomor urut
             var info = table.page.info();
            var pageNum = info.page;
            var length = info.length;
            var number = pageNum * length + dataIndex + 1;
            $('td', row).eq(0).html(number);

            // Menambahkan kelas 'text-center' ke kolom kelima (desc)
            // $('td', row).eq(4).addClass('text-center');
        }
    });

    // Event delegation untuk tombol delete
    $(document).on('click', '.delete-item', function() {
        var id = $(this).data('id');

        console.log('Item ID:', id); // Log ID untuk memastikan ID benar

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('pricelist.delete') }}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        itemID: id
                    },
                    success: function(data) {
                        console.log('Success:', data); // Log respons sukses

                        table.ajax.reload();
                        if (data.status === 'success') {
                            Swal.fire('Deleted!', data.message, 'success');
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    },
                    error: function(data) {
                        console.error('Error:', data); // Log respons kesalahan

                        Swal.fire('Error', 'There was an error deleting the item.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
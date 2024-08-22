@extends('layouts-admin.app')
@section('title', 'RACE NET | Dedicated Internet')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dedicated Internet</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dedicated Internet</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
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

                <!-- Card Tabel 1 -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title">Dedicated Internet</h5>
                        </div>
                        @include('admin.dedicated.table')
                    </div>
                </div>

                <!-- Card Tabel 2 -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="card-title">List Dedicated Internet Detail</h5>
                            <div class="py-3">
                                <a href="{{ route('dedicated-detail.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> New Broadband Internet
                                </a>
                            </div>
                        </div>
                        @include('admin.dedicated.table-detail')
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
        // Tabel 1
        var tableDedicated = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            paging: false,
            searching: false,
            info: false,
            ajax: {
                url: "{{ route('dedicated.index') }}",
                data: {
                    table: 'dedicated'
                } // Kirim parameter untuk menentukan tabel
            },
            columns: [{
                    data: null,
                    name: 'index',
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // Return the row index + 1
                    },
                    orderable: false, // Disable ordering on this column
                    searchable: false // Disable searching on this column
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'desc',
                    name: 'desc'
                },
                {
                    data: 'image',
                    name: 'image',
                    render: function(data, type, full, meta) {
                        return data;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        // Tabel 2
        var tableDedicatedDetail = $('.data-table-detail').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            ajax: {
                url: "{{ route('dedicated.index') }}",
                data: {
                    table: 'dedicated-detail'
                }
            },
            columns: [{
                    data: null,
                    name: 'index',
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // Return the row index + 1
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'link',
                    name: 'link',
                    render: function(data, type, full, meta) {
                        // Ensure that data is properly rendered as HTML
                        return data;// Directly use the data as HTML
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                
                {
                    data: 'desc',
                    name: 'desc'
                },
               
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        // Handle delete button di tabel kedua
        $('.data-table-detail').on('click', '.delete-item', function() {
            var id = $(this).data('id');

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
                        url: "{{ route('dedicated-detail.delete') }}",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            itemID: id
                        },
                        success: function(data) {
                            tableDedicatedDetail.ajax.reload();
                            if (data.status === 'success') {
                                Swal.fire('Deleted!', data.message, 'success');
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        },
                        error: function(data) {
                            console.error('Error:', data);
                            Swal.fire('Error', 'An error occurred while deleting the content.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
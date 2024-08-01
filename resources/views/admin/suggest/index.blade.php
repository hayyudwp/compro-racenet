@extends('layouts-admin.app')
@section('title', 'RACE NET | Suggest')

@section('content')


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Suggest</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Suggest</li>
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
                            <h5 class="card-title">Suggest</h5>
                        </div>
                        <!-- Table with stripped rows -->

                        <div class="table-responsive">
                            <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
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
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            language: {          
                processing: "<div class='spinner-border text-primary' role='status'><span class='visually-hidden'>Loading...</span></div>",
            },
            ajax: "{{ route('suggest.index') }}",
            columns: [
                {
                    data: null,
                    name: 'index',
                    render: function(data, type, full, meta) {
                        return meta.row + 1; // Return the row index + 1
                    },
                    orderable: false, // Disable ordering on this column
                    searchable: false // Disable searching on this column
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'message',
                    name: 'message'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                // $('td', row).eq(4).addClass('text-center');
            }
        });

        // Handle delete button click
       
    });
</script>
@endpush
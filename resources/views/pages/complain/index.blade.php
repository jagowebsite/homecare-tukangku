@extends('layouts.main', [
'title' => 'Complain Pembeli - Tukangku',
'menu' => 'consumen',
'submenu' => 'complain'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Konsumen</a>
            <span class="breadcrumb-item active">Complain</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Complain Pembeli</h4>
        <p class="mg-b-0">Semua data Complain Pesanan oleh pembeli</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Complain Pembeli</h6>
            <p class="mg-b-25 mb-4">Semua Complain Pesanan Homecare - Tukangku.</p>

            {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">Date</th>
                            <th class="">Kode Transaksi</th>
                            <th class="">Nama Pembeli</th>
                            <th class="">Deskripsi</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <div class="modal" tabindex="-1" id="editCategory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Komplain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Komplain Telah di selesaikan?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <a type="button" id="btn-confirm" class="btn btn-primary">Konfirmasi</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).on("click", ".btn-konfirmasi", function(e) {
            let urlconfirm = $(this).data('urlconfirm');
            $("#btn-confirm").attr("href", urlconfirm);
        });
        $(function() {

            $('#datatable2').DataTable({
                // responsive: true,
                "scrollX": true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                // "order": [6, 'desc'],
                processing: true,
                serverSide: true,
                ajax: "{{ route('complains') }}",
                columns: [
                    {
                        data: 'date_complain',
                        name: 'created_at',
                    },
                    {
                        data: 'invoice',
                        name: 'order.invoice_code'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'description',
                        name: 'description',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection

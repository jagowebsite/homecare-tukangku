@extends('layouts.main', [
'title' => 'View User Pembeli - Tukangku',
'menu' => 'consumen',
'submenu' => 'transactions'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Konsumen</a>
            <span class="breadcrumb-item active">Transaksi Pembeli</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Transaksi</h4>
        <p class="mg-b-0">Semua data transaksi layanan pembeli</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Transaksi Pembeli</h6>
            <p class="mg-b-25 mb-4">Semua Transaksi Layanan Homecare - Tukangku.</p>

            {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p">Invoice</th>
                            <th class="wd-15p">Nama</th>
                            <th class="wd-25p">Jasa/Layanan</th>
                            <th class="wd-15p">Total Harga</th>
                            <th class="wd-15p">Status</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>F7FD9879</td>
                            <td>Akmal Roziq</td>
                            <td>
                                Bebersih Rumah Mewah
                                <br>
                                <a href="">
                                    Lihat layanan
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </td>
                            <td>Rp 100.000</td>
                            <td>
                                <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Selesai
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('transactions_confirmation') }}" class="btn btn-success active"><i
                                            class="fa fa-check-circle"></i> Konfirmasi</a>
                                    <a href="{{ route('transactions_detail') }}" class="btn btn-secondary"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('order_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="order_id" id="order_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
         $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault()
            let order_id = $(this).data('order_id');
            $("#form_delete #order_id").val(order_id);
            if (order_id) {
                document.getElementById('form_delete').submit();
            }
        });
        $(function() {

            $('#datatable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('transactions') }}",
                columns: [{
                        data: 'invoice_code',
                        name: 'invoice_code'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name',
                    },
                    {
                        data: 'service_name',
                        name: 'orderDetails.service.name'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        searchable: false
                    },
                    {
                        data: 'status_order',
                        name: 'status_order'
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

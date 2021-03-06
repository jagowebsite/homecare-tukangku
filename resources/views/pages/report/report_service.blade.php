@extends('layouts.main', [
'title' => 'Laporan - Jasa',
'menu' => 'report',
'submenu' => 'service'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Laporan</a>
            <span class="breadcrumb-item active">Laporan Jasa</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Laporan Jasa</h4>
        <p class="mg-b-0">Semua data Laporan Jasa</p>
    </div>
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Eksport Laporan Report Penjualan</h6>
            {{-- <p class="mg-b-25 mb-4">Semua Laporan Seluruh Penjual Homecare - Tukangku.</p> --}}
            <form id="form-filter" action="{{ route('export_report_service') }}" method="GET" target="_blank">
                <div class="row ml-3 d-flex align-items-end">
                    <div class="col-md-4 mt-3 pt-3">
                        <label for="">Start Date</label>

                        <input class="form-control" type="date" id="start_date" name="start_date"
                            value="{{ old('start_date') }}">
                    </div>
                    <div class="col-md-4 mt-3 pt-3">
                        <label for="">End Date</label>
                        <input class="form-control" type="date" id="end_date" name="end_date"
                            value="{{ old('end_date') }}">
                    </div>
                    <div class="col-md-3 col-6 mt-3 pt-3">
                        <button class="btn btn-secondary" type="submit" style="height: 45px;">Eksport</button>
                    </div>
                </div>
            </form>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Laporan Jasa</h6>
            <p class="mg-b-25 mb-4">Semua Laporan Jasa Layanan Homecare - Tukangku.</p>

            {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">Date</th>
                            <th class="">Nama Konsumen</th>
                            <th class="">Email</th>
                            <th class="">No Hp</th>
                            <th class="">Alamat</th>
                            <th class="">Jenis Jasa</th>
                            <th class="">Status</th>
                            <th class="">Harga Total</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>
                                <a href="">1</a>
                            </td>
                            <td>Akmal Roziq</td>
                            <td>akmal@gmail.com</td>
                            <td>045849584</td>
                            <td>Jl Lontar Lamongan</td>
                            <td>Bebersih - Menyapu semua ruangan rumah</td>
                            <td>Selesai</td>
                            <td>Rp 100.000</td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

@section('scripts')

    <script>
        $(function() {

            $('#datatable2').DataTable({
                // responsive: true,
                "scrollX": true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('report_service') }}",
                columns: [{
                        data: 'date_order',
                        name: 'created_at'
                    },
                    {
                        data: 'order.user.name',
                        name: 'order.user.name',
                    },
                    {
                        data: 'order.user.email',
                        name: 'order.user.email'
                    },
                    {
                        data: 'order.user.number',
                        name: 'order.user.number',
                    },
                    {
                        data: 'order.user.address',
                        name: 'order.user.address'
                    },
                    {
                        data: 'service.name',
                        name: 'service.name'
                    },
                    {
                        data: 'status_order_detail',
                        name: 'status_order_detail'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
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

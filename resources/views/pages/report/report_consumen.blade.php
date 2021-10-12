@extends('layouts.main', [
'title' => 'Laporan - Seluruh Penjual',
'menu' => 'report',
'submenu' => 'consumen'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Laporan</a>
            <span class="breadcrumb-item active">Laporan Seluruh Penjual</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Laporan Penjual</h4>
        <p class="mg-b-0">Semua Laporan Seluruh</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Laporan Penjual</h6>
            <p class="mg-b-25 mb-4">Semua Laporan Seluruh Penjual Homecare - Tukangku.</p>

            {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-5p">No</th>
                            <th class="wd-15p">Nama Konsumen</th>
                            <th class="wd-25p">Email</th>
                            <th class="wd-15p">No Hp</th>
                            <th class="wd-5p">Alamat</th>
                            <th class="wd-5p">Jenis Jasa</th>
                            <th class="wd-5p">Status</th>
                            <th class="wd-5p">Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

@section('scripts')

    <script>
        $(function() {

            $('#datatable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection

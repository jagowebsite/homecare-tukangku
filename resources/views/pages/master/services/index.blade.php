@extends('layouts.main', [
'title' => 'Data Jasa - Tukangku',
'menu' => 'master',
'submenu' => 'services'
])

@section('style')
    <link href="{{ url('/') }}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <span class="breadcrumb-item active">Data Jasa</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Jasa</h4>
        <p class="mg-b-0">Semua data jasa Tukangku</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Jasa</h6>
            <p class="mg-b-25 mb-4">Semua Jasa Layanan Homecare - Tukangku.</p>

            <a href="{{ route('services_create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah
                Jasa</a>

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Image</th>
                            <th class="">Nama Jasa</th>
                            <th class="">Kategori</th>
                            <th class="">Harga</th>
                            <th class="">Type</th>
                            <th class="">Status</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="https://picsum.photos/64" class="wd-100 rounded" alt="">
                            </td>
                            <td>Service AC Cepat Kilat</td>
                            <td>Service AC</td>
                            <td></td>
                            <td>Rp 1.000.000</td>
                            <td>Aktif</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('services_edit', ['id' => 1]) }}"
                                        class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('services_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="service_id" id="service_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        // how to delete category
        $(document).on("click", ".btn-delete-service", function(e) {
            e.preventDefault()
            let service_id = $(this).data('service_id');
            $("#form_delete #service_id").val(service_id);
            if (service_id) {
                document.getElementById('form_delete').submit();
            }
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
                processing: true,
                serverSide: true,
                ajax: "{{ route('services') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'images',
                        name: 'images',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'serviceCategory',
                        name: 'serviceCategory.name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'type_quantity',
                        name: 'type_quantity'
                    },
                    {
                        data: 'status_service',
                        name: 'status_service'
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

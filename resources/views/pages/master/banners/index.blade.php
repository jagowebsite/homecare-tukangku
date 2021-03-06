@extends('layouts.main', [
'title' => 'Data Banners - Tukangku',
'menu' => 'master',
'submenu' => 'banners'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <span class="breadcrumb-item active">Data Banner</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Banner</h4>
        <p class="mg-b-0">Semua data banner untuk aplikasi</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Banner</h6>
            <p class="mg-b-25 mb-4">Semua Banner Layanan Homecare - Tukangku.</p>

            <a href="{{ route('banners_create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah
                Banner</a>

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Image</th>
                            <th class="">Nama Banner</th>
                            <th class="">Url</th>
                            <th class="">Is Active</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="https://picsum.photos/64" class="wd-100 rounded" alt="">
                            </td>
                            <td>Grand Opening</td>
                            <td>https://tukangku.co.id</td>
                            <td>Ya</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('banners_edit', 1) }}" class="btn btn-secondary active"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('banners_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="asset_id" id="asset_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        $(document).on("click", ".btn-delete-asset", function(e) {
            e.preventDefault()
            let asset_id = $(this).data('asset_id');
            $("#form_delete #asset_id").val(asset_id);
            if (asset_id) {
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
                ajax: "{{ route('banners') }}",
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
                        data: 'url_asset',
                        name: 'url_asset'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'action',
                        name: 'created_at',
                        // orderable: false,
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

@extends('layouts.main', [
'title' => 'Kategori Jasa - Tukangku',
'menu' => 'master',
'submenu' => 'services_category'
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
            <span class="breadcrumb-item active">Data Kategori</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Kategori</h4>
        <p class="mg-b-0">Semua data dategori layanan</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Kategori</h6>
            <p class="mg-b-25 mb-4">Semua Kategori Layanan Homecare - Tukangku.</p>

            <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i
                    class="fa fa-plus"></i> Tambah Kategori</button>

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Nama Kategori</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>Akmal Roziq</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button data-toggle="modal" data-target="#editCategory"
                                        class="btn btn-secondary active"><i class="fa fa-edit"></i></button>
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    <!--  ADD CATEGORIES -->
    <div id="addCategory" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Kategori</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_add-category" method="POST" action="{{ route('categories_store') }}">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Tambah Kategori</h4>
                        <div class="form-group">
                            <label for="">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save
                            changes</button>
                        <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!--  EDIT CATEGORIES -->
    <div id="editCategory" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Kategori</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit-category" method="POST" action="">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Edit Kategori</h4>
                        <div class="form-group">
                            <label for="">Nama Kategori</label>
                            <input type="text" name="name" id="name_edit" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save
                            changes</button>
                        <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <form id="form_delete" action="{{ route('categories_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="category_id" id="category_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        //how to delete category
        $(document).on("click", ".btn-edit-category", function() {
            let url = $(this).data('url');
            let category = $(this).data('name');
            $(".modal-body .form-group #name_edit").val(category);
            $("#form_edit-category").attr("action", url);
        });
        // how to delete category
        $(document).on("click", ".btn-delete-category", function(e) {
            e.preventDefault()
            let category_id = $(this).data('category_id');
            $("#form_delete #category_id").val(category_id);
            if (category_id) {
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
                ajax: "{{ route('services_categories') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',
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

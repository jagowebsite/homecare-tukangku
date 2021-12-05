@extends('layouts.main', [
    'title' => 'User Data - Tukangku',
    'menu' => 'users',
    'submenu' => 'user_datas'
  ])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Management User</a>
            <span class="breadcrumb-item active">User Data</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Akses Role</h4>
        <p class="mg-b-0">Akses Role dan Perizinan Penguna</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Data User</h6>
            <p class="mg-b-25 mb-4">Semua users homecare - Tukangku.</p>

            <a href="{{ route('users_create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah
                User</a>

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Foto</th>
                            <th class="wd-15p">Nama</th>
                            <th class="wd-20p">Email</th>
                            <th class="wd-20p">Tanggal Lahir</th>
                            <th class="wd-20p">Telp</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('users_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="user_id" id="user_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        // how to delete role
        $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault()
            let user_id = $(this).data('user_id');
            $("#form_delete #user_id").val(user_id);
            if (user_id) {
                document.getElementById('form_delete').submit();
            }
        });
        $(function() {

            let table_user = $('#datatable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_images',
                        name: 'user_images',
                        orderable: false,
                        searchable: false
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
                        data: 'date_of_birth',
                        name: 'date_of_birth'
                    },
                    {
                        data: 'number',
                        name: 'number'
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

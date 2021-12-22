@extends('layouts.main', [
'title' => 'Pendaftaran Konsumen - Tukangku',
'menu' => 'consumen_users',
'submenu' => ''
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
        <h4 class="tx-gray-800 mg-b-5">Data User Customer</h4>
        <p class="mg-b-0">Riwayat pendaftaran pedaftaran customer</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Data User Costumer</h6>
            <p class="mg-b-25 mb-4">Semua users homecare - Tukangku.</p>

            {{-- <a href="{{ route('users_create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah
                User</a> --}}

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Tanggal Pendaftaran</th>
                            <th class="">Foto</th>
                            <th class="">Nama</th>
                            <th class="">Email</th>
                            <th class="">Tanggal Lahir</th>
                            <th class="">Telp</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="https://picsum.photos/64" class="wd-40 rounded-circle" alt="">
                            </td>
                            <td>Akmal Roziq</td>
                            <td>roziq@gmail.com</td>
                            <td>17-08-1998</td>
                            <td>0856513213</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('consumen_users_edit', 1) }}" class="btn btn-secondary active"><i
                                            class="fa fa-edit"></i></button>
                                        <a href="" type="button" class="btn btn-secondary"><i
                                                class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('consumen_users_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="user_id" id="user_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')
    <script>
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
                // responsive: true,
                "scrollX": true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('consumen_users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_date',
                        name: 'created_at',

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

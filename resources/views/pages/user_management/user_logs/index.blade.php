@extends('layouts.main', [
'title' => 'User Logs - Tukangku',
'menu' => 'users',
'submenu' => 'user_logs'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Management User</a>
            <span class="breadcrumb-item active">User Log</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Log Semua User</h4>
        <p class="mg-b-0">Menampilkan Semua Log User</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Log User</h6>
            <p class="mg-b-25 mb-4">Semua logs user Homecare - Tukangku.</p>

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Nama</th>
                            <th class="wd-20p">Email</th>
                            <th class="wd-20p">Type</th>
                            <th class="wd-20p">Description</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>Akmal Roziq</td>
                            <td>Websitejago@gmail.com</td>
                            <td>Create</td>
                            <td>Menambahkan pesanan baru</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Akmal Roziq</td>
                            <td>Websitejago@gmail.com</td>
                            <td>Create</td>
                            <td>Menambahkan pesanan baru</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
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
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('user_logs') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name',
                    },
                    {
                        data: 'user.email',
                        name: 'user.email'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'description',
                        name: 'description'
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

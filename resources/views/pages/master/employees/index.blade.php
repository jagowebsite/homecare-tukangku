@extends('layouts.main', [
  'title' => 'Data Tukang - Tukangku',
  'menu' => 'master',
  'submenu' => 'employees'
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
            <span class="breadcrumb-item active">Data Tukang</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Tukang</h4>
        <p class="mg-b-0">Semua data tukang yang mengerjakan layanan</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Tukang</h6>
            <p class="mg-b-25 mb-4">Semua Tukang Homecare - Tukangku.</p>

            <a href="{{ route('employees_create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah
                Tukang</a>

            <div class="table-wrapper">
                <table id="datatable2" class="table w-100">
                    <thead>
                        <tr>
                            <th class="">ID</th>
                            <th class="">Foto</th>
                            <th class="">Kategori Layanan</th>
                            <th class="">Nama</th>
                            <th class="">Telp</th>
                            <th class="">Is Ready</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="" class="wd-40 rounded-circle" alt="">
                            </td>
                            <td>Srvice AC</td>
                            <td>Akmal Roziq</td>
                            <td>08560454545</td>
                            <td>Aktif</td>
                            <td>Ya</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('employees_edit') }}" class="btn btn-secondary active"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="" type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <img src="" class="wd-40 rounded-circle" alt="">
                            </td>
                            <td>Renovasi</td>
                            <td>Akmal Roziq</td>
                            <td>Websitejago@gmail.com</td>
                            <td>17-08-2000</td>
                            <td>08560454545</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('employees_edit') }}" class="btn btn-secondary active"><i
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
    <form id="form_delete" action="{{ route('employees_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="employee_id" id="employee_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        $(document).on("click", ".btn-delete-employee", function(e) {
            e.preventDefault()
            let employee_id = $(this).data('employee_id');
            $("#form_delete #employee_id").val(employee_id);
            if (employee_id) {
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
                ajax: "{{ route('employees') }}",
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
                        data: 'serviceCategory',
                        name: 'serviceCategory.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'number',
                        name: 'number'
                    },
                    {
                        data: 'is_ready',
                        name: 'is_ready'
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

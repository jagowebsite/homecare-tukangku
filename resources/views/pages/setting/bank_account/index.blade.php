@extends('layouts.main', [
'title' => 'Data Rekening - Tukangku',
'menu' => 'master',
'submenu' => 'rekening'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Setting</a>
            <span class="breadcrumb-item active">Data Nomor Rekening</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Data Rekening</h4>
        <p class="mg-b-0">Semua data Rekening Pembayaran Tukangku</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Nomor Rekening</h6>
            <p class="mg-b-25 mb-4">Semua Nomor Rekening Pembayaran Homecare - Tukangku.</p>

            <a href="{{ route('account_create') }}" class="btn btn-primary mb-4">
                <i class="fa fa-plus"></i>Tambah Rekening
            </a>

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive w-100">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Nama Akun</th>
                            <th class="wd-15p">Nomor Rekening</th>
                            <th class="wd-15p">Nama Bank</th>
                            <th class="wd-15p">Is Active</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                    
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
    <form id="form_delete" action="{{ route('account_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="rekening_id" id="rekening_id" placeholder="" value="">
    </form>
@endsection

@section('scripts')

    <script>
        $(document).on("click", ".btn-delete-accountpayment", function(e) {
            e.preventDefault()
            let rekening_id = $(this).data('rekening_id');
            $("#form_delete #rekening_id").val(rekening_id);
            if (rekening_id) {
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
                ajax: "{{ route('bank_account') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'account_name',
                        name: 'account_name',
                        // orderable: false,
                        // searchable: false
                    },
                    {
                        data: 'account_number',
                        name: 'account_number'
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'active_account',
                        name: 'filter_active',
                        // searchable: false
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

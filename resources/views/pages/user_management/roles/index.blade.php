@extends('layouts.main', [
    'title' => 'User Roles - Tukangku',
    'menu' => 'users',
    'submenu' => 'user_roles'
  ])

@section('style')
    <link href="{{ url('/') }}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <style>
        .badge-permission {
            padding: 10px;
            background-color: #17A2B8;
        }

    </style>
@endsection

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Management User</a>
            <span class="breadcrumb-item active">Roles</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Akses Role</h4>
        <p class="mg-b-0">Akses Role dan Perizinan Penguna</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Akses Role</h6>
            <p class="mg-b-25 mb-4">Role Pengguna.</p>

            <button data-toggle="modal" data-target="#addRole" class="btn btn-primary mb-4"><i class="fa fa-plus"></i>
                Tambah Role</button>

            <div class="table-wrapper">
                <table id="datatable1" class="table display responsive">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-20p">Guard Name</th>
                            <th class="wd-15p">Permission</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- table-wrapper -->
        </div>
        <div class="br-section-wrapper mt-3">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Perizinan</h6>
            <p class="mg-b-25 mb-4">Perizinan Pengguna.</p>

            <button data-toggle="modal" data-target="#AddPermission" class="btn btn-primary mb-4"><i
                    class="fa fa-plus"></i>
                Tambah Akses</button>

            <div class="table-wrapper">
                <table id="datatable2" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-5p">ID</th>
                            <th class="wd-15p">Name</th>
                            <th class="wd-15p">Guard Name</th>
                            <th class="wd-5p">Action</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->


    <!--  TAMBAH ROLE MODAL -->
    <div id="addRole" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Role</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_add-role" method="POST" action="{{ route('roles_store') }}">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-6 mg-b-20">Tambah Role User</h4>
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label for="">Guard Name</label>
                            <input type="text" name="guar_name" id="guard_name" value="web" class="form-control"
                                placeholder="">
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

    <!--  EDIT ROLE MODAL -->
    <div id="editRole" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Role</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit-role" method="POST" action="">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Edit Role User</h4>
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" name="name" id="name_edit" class="form-control" placeholder="" value="">
                        </div>
                        <div class="form-group">
                            <label for="">Guard Name</label>
                            <input type="text" name="guard_name" id="guard_name_edit" value="" class="form-control"
                                placeholder="">
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

    <!--  ADD PERMISSION TO ROLE MODAL -->
    <div id="AddPermissionToRole" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Permission Role</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_roles-permissions" method="POST" action="">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Tambah Perizinan Ke Role</h4>
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" name="" id="role_name" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Perizinan</label>
                            <select class="form-control" name="permission" id="permission">
                                <option value="">Choose...</option>
                                @isset($permissions)
                                    @foreach ($permissions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->guard_name }})
                                        </option>
                                    @endforeach
                                @endisset

                            </select>
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

    <!--  ADD PERMISSION MODAL -->
    <div id="AddPermission" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Permission User</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_add-permission" method="POST" action="{{ route('permissions_store') }}">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Tambah Perizinan</h4>
                        <div class="form-group">
                            <label for="">Nama Perizinan</label>
                            <input type="text" name="name" id="" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Guard Name</label>
                            <input type="text" name="guard_name" id="" class="form-control" placeholder="" value="web">
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

    <!--  EDIT PERMISSION MODAL -->
    <div id="EditPermission" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Permission User</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit-permission" method="POST" action="">
                    @csrf
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20">Edit Perizinan</h4>
                        <div class="form-group">
                            <label for="">Nama Perizinan</label>
                            <input type="text" name="name" id="permission_name" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Guard Name</label>
                            <input type="text" name="guard_name" id="permission_guard" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save
                            changes</button>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

    <form id="form_revoke-permission" action="{{ route('revoke_permission') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="role_id" id="role_id" placeholder="" value="">
        <input type="text" name="permission_id" id="permission_id" placeholder="" value="">
    </form>
    <form id="form_role-delete" action="{{ route('roles_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="role_id" id="role_id" placeholder="" value="">
    </form>
    <form id="form_permission-delete" action="{{ route('permissions_destroy') }}" method="POST" hidden>
        @method('delete')
        @csrf
        <input type="text" name="permission_id" id="permission_id" placeholder="" value="" hidden>
    </form>
@endsection

@section('scripts')

    <script>
        // how to removed permission from a role
        $(document).on("click", ".revoke-permission", function(e) {
            e.preventDefault()
            let role_id = $(this).data('role_id');
            let permission_id = $(this).data('permission_id');
            $("#form_revoke-permission #role_id").val(role_id);
            $("#form_revoke-permission #permission_id").val(permission_id);

            if (role_id && permission_id) {
                document.getElementById('form_revoke-permission').submit();
            }
        });
        // how to add permission from a role
        $(document).on("click", ".btn-roles-permissions", function(e) {
            let url = $(this).data('url');
            let role_name = $(this).data('name');
            // console.log(url)
            $(".modal-body .form-group #role_name").val(role_name);
            $("#form_roles-permissions").attr("action", url);
        });
        // how to delete role
        $(document).on("click", ".btn-delete-role", function(e) {
            e.preventDefault()
            let role_id = $(this).data('role_id');
            $("#form_role-delete #role_id").val(role_id);
            if (role_id) {
                document.getElementById('form_role-delete').submit();
            }
        });
        // how to edit-role
        $(document).on("click", ".btn-edit-role", function() {
            let url = $(this).data('url');
            let role_name = $(this).data('name');
            let guard_name = $(this).data('guard_name');
            // console.log(url)
            $(".modal-body .form-group #name_edit").val(role_name);
            $(".modal-body .form-group #guard_name_edit").val(guard_name);
            $("#form_edit-role").attr("action", url);
        });

        // how to edit-permission
        $(document).on("click", ".btn-edit-permission", function() {
            let url = $(this).data('url');
            let permission_name = $(this).data('name');
            let guard_name = $(this).data('guard_name');
            // console.log(url)
            $(".modal-body .form-group #permission_name").val(permission_name);
            $(".modal-body .form-group #permission_guard").val(guard_name);
            $("#form_edit-permission").attr("action", url);
        });

        // how to delete permission
        $(document).on("click", ".btn-delete-permission", function(e) {
            e.preventDefault()
            let permission_id = $(this).data('permission_id');
            $("#form_permission-delete #permission_id").val(permission_id);
            if (permission_id) {
                document.getElementById('form_permission-delete').submit();
            }
        });
        $(function() {
            // 'use strict';
            // setup table role from server side
            $('#datatable1').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_roles') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'guard_name',
                        name: 'guard_name'
                    },
                    {
                        data: 'role_permission',
                        name: 'role_permission',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#datatable2').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('permissions') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'guard_name',
                        name: 'guard_name'
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

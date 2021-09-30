@extends('layouts.main')

@section('style')
    <link href="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')

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
      
      <button data-toggle="modal" data-target="#addRole" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Role</button>

      <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-5p">ID</th>
              <th class="wd-15p">Name</th>
              <th class="wd-20p">Guard Name</th>
              <th class="wd-15p">Permission</th>
              <th class="wd-5p">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Admin</td>
              <td>web</td>
              <td>
                  <input type="text" value="Read, Update, Delete" data-role="tagsinput">
                </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button data-toggle="modal" data-target="#editRole" class="btn btn-secondary active"><i class="fa fa-edit"></i></button>
                    <button data-toggle="modal" data-target="#AddPermissionToRole" class="btn btn-secondary active"><i class="fa fa-cog"></i></button>
                    <a href=""  class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div>
    <div class="br-section-wrapper mt-3">
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Perizinan</h6>
      <p class="mg-b-25 mb-4">Perizinan Pengguna.</p>

      <button data-toggle="modal" data-target="#AddPermission" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Akses</button>

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
          <tbody>
            <tr>
              <td>1</td>
              <td>Read</td>
              <td>web</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button data-toggle="modal" data-target="#EditPermission"  class="btn btn-secondary active"><i class="fa fa-edit"></i></button>
                  <a href=""  class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
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
        <div class="modal-body pd-25">
          <h4 class="lh-6 mg-b-20">Tambah Role User</h4>
          <div class="form-group">
            <label for="">Nama Role</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Guard Name</label>
            <input type="text" name="" id="" value="web" class="form-control" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
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
        <div class="modal-body pd-25">
          <h4 class="lh-3 mg-b-20">Edit Role User</h4>
          <div class="form-group">
            <label for="">Nama Role</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Guard Name</label>
            <input type="text" name="" id="" value="web" class="form-control" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
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
        <div class="modal-body pd-25">
          <h4 class="lh-3 mg-b-20">Tambah Perizinan Ke Role</h4>
          <div class="form-group">
            <label for="">Nama Role</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Nama Perizinan</label>
            <select class="form-control" name="" id="">
              <option>Read</option>
              <option>Update</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
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
        <div class="modal-body pd-25">
          <h4 class="lh-3 mg-b-20">Tambah Perizinan</h4>
          <div class="form-group">
            <label for="">Nama Perizinan</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Guard Name</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
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
        <div class="modal-body pd-25">
          <h4 class="lh-3 mg-b-20">Edit Perizinan</h4>
          <div class="form-group">
            <label for="">Nama Perizinan</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
          <div class="form-group">
            <label for="">Guard Name</label>
            <input type="text" name="" id="" class="form-control" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
          <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->
  
    
@endsection

@section('scripts')

<script>
    $(function(){
      'use strict';

      $('#datatable1').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      $('#datatable2').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
</script>
@endsection
@extends('layouts.main')

@section('style')
    <link href="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="index.html">Bracket</a>
      <a class="breadcrumb-item" href="#">Tables</a>
      <span class="breadcrumb-item active">Data Table</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Akses Role</h4>
    <p class="mg-b-0">Akses Role dan Perizinan Penguna</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Akses Role</h6>
      <p class="mg-b-25 mg-lg-b-50">Role Pengguna.</p>

      <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">ID</th>
              <th class="wd-15p">Name</th>
              <th class="wd-20p">Guard Name</th>
              <th class="wd-15p">Permission</th>
              <th class="wd-10p">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Admin</td>
              <td>web</td>
              <td>
                  {{-- <input type="text" value="Read, Update, Delete" data-role="tagsinput"> --}}
                </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary active"><i class="fa fa-home"></i></button>
                    <button type="button" class="btn btn-secondary"><i class="fa fa-envelope"></i></button>
                    <button type="button" class="btn btn-secondary"><i class="fa fa-cog"></i></button>
                  </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div><!-- table-wrapper -->

      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-t-80 mg-b-10">Perizinan</h6>
      <p class="mg-b-25 mg-lg-b-50">Perizinan Pengguna.</p>

      <div class="table-wrapper">
        <table id="datatable2" class="table display responsive nowrap">
          <thead>
            <tr>
              <th class="wd-15p">First name</th>
              <th class="wd-15p">Last name</th>
              <th class="wd-20p">Position</th>
              <th class="wd-15p">Start date</th>
              <th class="wd-10p">Salary</th>
              <th class="wd-25p">E-mail</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Tiger</td>
              <td>Nixon</td>
              <td>System Architect</td>
              <td>2011/04/25</td>
              <td>$320,800</td>
              <td>t.nixon@datatables.net</td>
            </tr>
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
    
@endsection

@section('scripts')

<script src="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
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
        bLengthChange: false,
        searching: false,
        responsive: true
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
</script>
@endsection
@extends('layouts.main')

@section('style')
    <link href="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')

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

      <a href="{{route('users_create')}}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah User</a>

      <div class="table-wrapper">
        <table id="datatable2" class="table display responsive nowrap">
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
          <tbody>
            <tr>
              <td>1</td>
              <td>
                  <img src="https://picsum.photos/64" class="wd-40 rounded-circle" alt="">
              </td>
              <td>Akmal Roziq</td>
              <td>Websitejago@gmail.com</td>
              <td>17-08-2000</td>
              <td>08560454545</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <a href="{{route('users_edit')}}"  class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                  <a href=""  type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                  <img src="https://picsum.photos/64" class="wd-40 rounded-circle" alt="">
              </td>
              <td>Akmal Roziq</td>
              <td>Websitejago@gmail.com</td>
              <td>17-08-2000</td>
              <td>08560454545</td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{route('users_edit')}}"  class="btn btn-secondary active"><i class="fa fa-edit"></i></a>
                    <a href=""  type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
    
@endsection

@section('scripts')

<script>
    $(function(){

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
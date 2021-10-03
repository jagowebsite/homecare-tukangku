@extends('layouts.main', [
  'title' => 'GPS Logs - Tukangku',
  'menu' => 'consumen',
  'submenu' => 'gps_logs'
])

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="">Homecare</a>
      <a class="breadcrumb-item" href="">Konsumen</a>
      <span class="breadcrumb-item active">Log GPS</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Data Log GPS</h4>
    <p class="mg-b-0">Semua data Log GPS pembeli</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Log GPS Pembeli</h6>
      <p class="mg-b-25 mb-4">Semua Log GPS Pembeli Homecare - Tukangku.</p>

      {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

      <div class="table-wrapper">
        <table id="datatable2" class="table display responsive nowrap">
          <thead>
            <tr>
                <th class="wd-5p">Invoice</th>
                <th class="wd-15p">Nama</th>
                <th class="wd-25p">Jasa/Layanan</th>
                <th class="wd-15p">GPS Logs</th>
                <th class="wd-5p">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <a href="">F7FD9879</a>
              </td>
              <td>Akmal Roziq</td>
              <td>
                    Bebersih Rumah Mewah
                    <br>
                    <a href="">
                        Lihat layanan 
                        <i class="fa fa-long-arrow-right"></i> 
                    </a>
                </td>
              <td>
                <div>-3487384, 58495794</div>
                <a href="">Lihat lokasi <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
              </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button data-toggle="modal" data-target="#editCategory"  class="btn btn-secondary active"><i class="fa fa-edit"></i></button>
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
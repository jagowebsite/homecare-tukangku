@extends('layouts.main')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="">Homecare</a>
      <a class="breadcrumb-item" href="">Konsumen</a>
      <span class="breadcrumb-item active">Pembayaran</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Data Transaksi Pembayaran</h4>
    <p class="mg-b-0">Semua data transaksi pembayaran layanan pembeli</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
      <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Semua Data Transaksi Pembayaran Pembeli</h6>
      <p class="mg-b-25 mb-4">Semua Transaksi Pembayaran Layanan Homecare - Tukangku.</p>

      {{-- <button data-toggle="modal" data-target="#addCategory" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Tambah Kategori</button> --}}

      <div class="table-wrapper">
        <table id="datatable2" class="table display responsive nowrap">
          <thead>
            <tr>
                <th class="wd-5p">Invoice</th>
                <th class="wd-5p">Kode</th>
                <th class="wd-15p">Nama</th>
                <th class="wd-25p">Jasa/Layanan</th>
                <th class="wd-25p">Tipe</th>
                <th class="wd-15p">Foto</th>
                <th class="wd-5p">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td>
                    <a href="">F7FD9879</a>
                </td>
              <td>001</td>
              <td>Akmal Roziq</td>
              <td>
                    Bebersih Rumah Mewah
                    <br>
                    <a href="">
                        Lihat layanan 
                        <i class="fa fa-long-arrow-right"></i> 
                    </a>
                </td>
              <td><i class="fa fa-check-circle text-success" aria-hidden="true"></i> Lunas</td>
              <td>
                <img src="https://picsum.photos/64" class="wd-100 rounded" alt="">
              </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button data-toggle="modal" data-target="#editCategory"  class="btn btn-success active"><i class="fa fa-check-circle"></i> Konfirmasi</button>
                  <a href="{{route('payments_detail')}}" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                  <a href=""  type="button" class="btn btn-secondary"><i class="fa fa-trash"></i></a>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                  <a href="">F7FD9879</a>
              </td>
              <td>001</td>
              <td>Akmal Roziq</td>
              <td>
                    Bebersih Rumah Mewah
                    <br>
                    <a href="">
                        Lihat layanan 
                        <i class="fa fa-long-arrow-right"></i> 
                    </a>
                </td>
              <td><i class="fa fa-hourglass text-warning" aria-hidden="true"></i> Uang Muka</td>
              <td>
                <img src="https://picsum.photos/64" class="wd-100 rounded" alt="">
              </td>
              <td>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button data-toggle="modal" data-target="#editCategory"  class="btn btn-success active"><i class="fa fa-check-circle"></i> Konfirmasi</button>
                  <a href="{{route('payments_detail')}}" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
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
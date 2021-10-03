@extends('layouts.main', [
    'title' => 'Konfirmasi Transaksi Pembeli - Tukangku',
    'menu' => 'consumen',
    'submenu' => 'transactions'
  ])

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item">Homecare</a>
      <a class="breadcrumb-item">Konsumen</a>
      <span class="breadcrumb-item">Transaksi Pembeli</span>
      <span class="breadcrumb-item active">Konfirmasi Transaksi</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Konfirmasi Transaksi Pembeli</h4>
    <p class="mg-b-0">Konfirmasi transaksi layanan pembeli</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Konfirmasi Transaksi Pembeli</h6>
        <p class="mg-b-25 mb-4">Konfirmasi Transaksi Layanan Homecare - Tukangku.</p>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="">Tanggal</label>
                      <input type="date"
                        class="form-control" name="" id="" value="{{date('Y-m-d')}}" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Pilih Tukang</label>
                      <select class="form-control" name="" id="">
                        <option>Pak Herman</option>
                        <option>Pak Sujiwo</option>
                        <option>Bu Nanik</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="">Upah Tukang</label>
                      <input type="text"
                        class="form-control number-format" name="" id="" placeholder="">
                    </div>
                    <div class="form-group">
                      <label for="">Durasi Kerja</label>
                      <input type="text"
                        class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Tipe Durasi Kerja</label>
                        <select class="form-control" name="" id="">
                          <option>Jam</option>
                          <option>Satuan</option>
                          <option>Tahun</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="">Deskripsi (Opsional)</label>
                      <textarea class="form-control" name="" id="" rows="3"></textarea>
                    </div>
                    <button class="btn btn-success mt-3">Konfirmasi Sekarang</button>
                </form>
            </div>
        </div>
        
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
@endsection
@extends('layouts.main', [
    'title' => 'Detail Transaksi Pembeli - Tukangku',
    'menu' => 'consumen',
    'submenu' => 'payments'
  ])

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="">Homecare</a>
      <a class="breadcrumb-item" href="">Konsumen</a>
      <span class="breadcrumb-item active">Detail Pembayaran</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Detail Transaksi Pembayaran</h4>
    <p class="mg-b-0">Detail transaksi pembayaran layanan pembeli</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Detail Transaksi Pembayaran Pembeli</h6>
        <p class="mg-b-25 mb-4">Detail Transaksi Pembayaran Layanan Homecare - Tukangku.</p>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card shadow-base bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Data Pembayaran</h6>
                        <span class="tx-12 tx-uppercase">12 February 2021</span>
                    </div><!-- card-header -->
                    <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">
                        <a href="">Bebersih Rumah Cepat Mewah</a>
                    </p>
                    <p class="tx-12">Kode Pembayaran: 97348758384</p>
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Invoice</div><!-- col-4 -->
                        <div class="col-8">
                            <a href="">3478945634</a>
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Tipe Transfer</div><!-- col-4 -->
                        <div class="col-8">
                            Cash
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">No Rek</div><!-- col-4 -->
                        <div class="col-8">
                            084758493278
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Nama Bank</div><!-- col-4 -->
                        <div class="col-8">
                            BRI
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Nama Rekening</div><!-- col-4 -->
                        <div class="col-8">
                            Jimmy Kurniawan
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Nominal</div><!-- col-4 -->
                        <div class="col-8">
                            Rp 1.000.000
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">status</div><!-- col-4 -->
                        <div class="col-8">
                            <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Lunas
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-start">
                        <div class="col-4 tx-12">Foto Bukti</div><!-- col-4 -->
                        <div class="col-8">
                            <a href="" target="_blank"><img src="https://picsum.photos/64" class="wd-60 rounded" alt=""></a>
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    
                    <p class="tx-11 mg-b-0 mg-t-15">Deskripsi: Pembayaran sudah sesuai.</p>
                    <button class="btn btn-sm btn-success mt-3">Konfirmasi Pembayaran</button>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="card shadow-base bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Data Konsumen</h6>
                        <span class="tx-12 tx-uppercase"></span>
                    </div><!-- card-header -->
                    <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">Jimmy Kurniawan</p>
                    <p class="tx-12">Jl Lontar Sambikerep Surabaya Jawa Timur</p>
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Latitude</div><!-- col-4 -->
                        <div class="col-8">
                            -768334574
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Longitude</div><!-- col-4 -->
                        <div class="col-8">
                            -768334574
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Lokasi</div><!-- col-4 -->
                        <div class="col-8">
                            <a href="">Lihat lokasi</a>
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-start">
                        <div class="col-4 tx-12">Foto konsumen</div><!-- col-4 -->
                        <div class="col-8">
                            <a href="" target="_blank"><img src="https://picsum.photos/64" class="wd-60 rounded" alt=""></a>
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    
                    <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data konsumen sudah sesuai.</p>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
        
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
@endsection
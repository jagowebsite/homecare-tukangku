@extends('layouts.main', [
    'title' => 'Detail transaksi User Pembeli - Tukangku',
    'menu' => 'consumen',
    'submenu' => 'transactions'
  ])

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="">Homecare</a>
      <a class="breadcrumb-item" href="">Konsumen</a>
      <span class="breadcrumb-item active">Detail Transaksi Pembeli</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Detail Transaksi Pembeli</h4>
    <p class="mg-b-0">Detail transaksi layanan pembeli</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Detail Transaksi Pembeli</h6>
        <p class="mg-b-25 mb-4">Detail Transaksi Layanan Homecare - Tukangku.</p>

        <div class="row">
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
                        <div class="col-4 tx-12">No Telp</div><!-- col-4 -->
                        <div class="col-8">
                            086556432132
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    
                    <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data konsumen sudah sesuai.</p>
                    </div><!-- card-body -->
                </div><!-- card -->
                <div class="card shadow-base bd-0 mt-3">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Data Transaksi</h6>
                        {{-- <span class="tx-12 tx-uppercase">12 February 2021</span> --}}
                    </div><!-- card-header -->
                    <div class="card-body">
                    <p class="tx-sm tx-inverse tx-medium mg-b-0">
                        <a href="">Bebersih Rumah Cepat Mewah</a>
                    </p>
                    <p class="tx-12">Invoice: 758384</p>

                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Tanggal</div><!-- col-4 -->
                        <div class="col-8">
                            12 February 2021
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Jumlah / Durasi</div><!-- col-4 -->
                        <div class="col-8">
                            2
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Harga</div><!-- col-4 -->
                        <div class="col-8">
                            Rp 100.000
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Total</div><!-- col-4 -->
                        <div class="col-8">
                            Rp 200.000
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">status</div><!-- col-4 -->
                        <div class="col-8">
                            <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Selesai
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <p class="tx-11 mg-b-0 mg-t-15">Deskripsi: Pembayaran sudah sesuai.</p>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="card shadow-base bd-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="card-title tx-uppercase tx-12 mg-b-0">Konfimasi Transaksi</h6>
                        {{-- <span class="tx-12 tx-uppercase">12 February 2021</span> --}}
                    </div><!-- card-header -->
                    <div class="card-body">
                    {{-- <p class="tx-sm tx-inverse tx-medium mg-b-0">
                        <a href="">Bebersih Rumah Cepat Mewah</a>
                    </p> --}}
                    {{-- <p class="tx-12">Invoice: 758384</p> --}}
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Tanggal</div><!-- col-4 -->
                        <div class="col-8">
                            12-02-2021
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Tukang</div><!-- col-4 -->
                        <div class="col-8">
                            Pak Akmal
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Upah Tukang</div><!-- col-4 -->
                        <div class="col-8">
                            Rp 50.000
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <div class="row align-items-center">
                        <div class="col-4 tx-12">Durasi pengerjaan</div><!-- col-4 -->
                        <div class="col-8">
                            9 Jam
                        </div><!-- col-8 -->
                    </div><!-- row -->
                    <p class="tx-11 mg-b-0 mg-t-15">Deskripsi : Pengerjaan dilakukan pagi hari</p>

                    {{-- Kalau belum dikonfirmasi, munculkan tombol ini saja --}}
                    <a href="{{route('transactions_confirmation')}}" class="btn btn-sm btn-success mt-3">Konfirmasi Transaksi</a>


                    </div><!-- card-body -->
                </div><!-- card -->
                <div class="card shadow-base bd-0 mt-3">
                    <div class="card-header bg-transparent pd-20">
                      <h6 class="card-title tx-uppercase tx-12 mg-b-0">Bukti Pembayaran Transaksi</h6>
                    </div><!-- card-header -->
                    <table class="table table-responsive mg-b-0 tx-12">
                      <thead>
                        <tr class="tx-10">
                          <th class="wd-10p pd-y-5">&nbsp;</th>
                          <th class="pd-y-5">Nama Konsumen</th>
                          <th class="pd-y-5">Status</th>
                          <th class="pd-y-5">Tanggal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="pd-l-20">
                            <img src="http://via.placeholder.com/280x280" class="wd-36 rounded" alt="Image">
                          </td>
                          <td>
                            <a href="" class="tx-inverse tx-14 tx-medium d-block">John L. Goulette</a>
                            <span class="tx-11 d-block">Kode: 1234567890</span>
                          </td>
                          <td class="tx-12">
                            <span class="square-8 bg-success mg-r-5 rounded-circle"></span> Lunas
                          </td>
                          <td>16 Agustus 2021</td>
                        </tr>
                      </tbody>
                    </table>
                  </div><!-- card -->
            </div>
        </div>
        
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
@endsection
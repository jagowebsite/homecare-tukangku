@extends('layouts.main', [
'title' => 'Detail Transaksi Pembeli - Tukangku',
'menu' => 'consumen',
'submenu' => 'payments'
])

@section('content')
    @include('layouts.alert')
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
                            <span
                                class="tx-12 tx-uppercase">{{ date_format(date_create($payment->created_at), 'd F Y') }}</span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            {{-- <p class="tx-sm tx-inverse tx-medium mg-b-0">
                        <a href="">Bebersih Rumah Cepat Mewah</a>
                    </p> --}}
                            <p class="tx-12">Kode Pembayaran: {{ $payment->payment_code }}</p>
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Invoice</div><!-- col-4 -->
                                <div class="col-8">
                                    <a href="">{{ $payment->order->invoice_code }}</a>
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Tipe Transfer</div><!-- col-4 -->
                                <div class="col-8 text-capitalize">
                                    {{ $payment->type_transfer }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">No Rek</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ $payment->bank_number }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Bank</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ $payment->bank_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Rekening</div><!-- col-4 -->
                                <div class="col-8 text-capitalize">
                                    {{ $payment->account_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nominal</div><!-- col-4 -->
                                <div class="col-8">
                                    Rp {{ number_format($payment->total_payment, 0, ',', '.') }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Status</div><!-- col-4 -->
                                <div class="col-8 text-capitalize">
                                    @if ($payment->type == 'lunas')
                                        <i class="fa fa-check-circle-o text-success " aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-hourglass text-warning" aria-hidden="true"></i>
                                    @endif
                                    {{ $payment->type }}
                                    {{-- <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Lunas --}}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-start">
                                <div class="col-4 tx-12">Foto Bukti</div><!-- col-4 -->
                                <div class="col-8">
                                    <a href="" target="_blank"><img
                                            src="{{ $payment->images_payment ? asset('storage/' . $payment->images_payment) : 'https://picsum.photos/64' }}"
                                            class="wd-60 rounded" alt=""></a>
                                </div><!-- col-8 -->
                            </div><!-- row -->

                            <p class="tx-11 mg-b-0 mg-t-15">Deskripsi: {{ $payment->description }}</p>
                            @if ($payment->status_payment == 'pending')
                                <a href=" {{ route('confirm_payment', ['id' => $payment->id]) }}"
                                    class="btn btn-sm btn-success mt-3">Konfirmasi Pembayaran</a>
                                <a href=" {{ route('cancel_payment', ['id' => $payment->id]) }}"
                                    class="btn btn-sm btn-danger mt-3">Tolak Pembayaran</a>
                            @else
                                <button type="button"
                                    class="btn btn-sm btn-secondary mt-3 tx-uppercase">{{ $payment->status_payment }}</button>
                            @endif
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
                            <p class="tx-sm tx-inverse tx-medium mg-b-0 text-capitalize">{{ $payment->user->name }}</p>
                            <p class="tx-12">{{ $payment->address }}</p>
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Latitude</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ $payment->latitude }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Longitude</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ $payment->longitude }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Lokasi</div><!-- col-4 -->
                                <div class="col-8">
                                    <a href="http://maps.google.com/maps?q={{ $payment->latitude }},{{ $payment->longitude }}"
                                        target="_blank">Lihat
                                        lokasi</a>
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-start">
                                <div class="col-4 tx-12">Foto konsumen</div><!-- col-4 -->
                                <div class="col-8">
                                    <a href="" target="_blank"><img
                                            src="{{ $payment->images_user ? asset('storage/' . $payment->images_user) : 'https://picsum.photos/64' }}"
                                            class="wd-60 rounded" alt=""></a>
                                </div><!-- col-8 -->
                            </div><!-- row -->

                            <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data konsumen sudah sesuai.</p>
                        </div><!-- card-body -->
                    </div><!-- card -->
                     @if ($payment->account_payment_id)
                    <div class="card shadow-base bd-0 mt-3">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Data Rekening Pembayaran</h6>
                            <span class="tx-12 tx-uppercase"></span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Akun</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->account_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nomor Rekening</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->account_number }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Bank</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->bank_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data rekening pembayaran benar.</p>
                        </div><!-- card-body -->
                    </div><!-- card -->
                    @endif
                </div>
                {{-- @if ($payment->account_payment_id) --}}
                {{-- <div class="col-md-6 col-xs-12 mt-2">
                    <div class="card shadow-base bd-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Data Rekening Pembayaran</h6>
                            <span class="tx-12 tx-uppercase"></span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Akun</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->account_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nomor Rekening</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->account_number }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">Nama Bank</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$payment->accountpayment->bank_name }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data rekening pembayaran benar.</p>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div> --}}
                {{-- @endif --}}
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

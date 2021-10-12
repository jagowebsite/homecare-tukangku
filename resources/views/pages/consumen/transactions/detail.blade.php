@extends('layouts.main', [
'title' => 'Detail transaksi User Pembeli - Tukangku',
'menu' => 'consumen',
'submenu' => 'transactions'
])

@section('content')
    @include('layouts.alert')
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
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Konfimasi Transaksi</h6>
                            {{-- <span class="tx-12 tx-uppercase">12 February 2021</span> --}}
                        </div><!-- card-header -->
                        <div class="card-body">
                            {{-- <p class="tx-sm tx-inverse tx-medium mg-b-0">
                                <a href="">Bebersih Rumah Cepat Mewah</a>
                            </p> --}}
                            <div class="row align-items-center">
                                <div class="col-5 tx-sm tx-inverse tx-medium mg-b-0">
                                    Daftar Pesanan
                                </div>
                                <div class="col-4 tx-sm tx-inverse tx-medium mg-b-0 text-center">
                                    Status
                                </div>
                                <div class="col-3 tx-sm tx-inverse tx-medium mg-b-0">
                                    Action
                                </div>
                            </div>
                            @foreach ($order->orderDetails as $orderDetail)
                                <div class="row align-items-center">
                                    <div class="col-5 tx-12">{{ @$orderDetail->service->serviceCategory->name }} -
                                        {{ @$orderDetail->service->name }}</div>
                                    <!-- col-4 -->
                                    <div class="col-4 text-center text-capitalize">
                                        {{ @$orderDetail->status_order_detail }}
                                    </div><!-- col-8 -->
                                    <div class="col-3 ">
                                        @if (@$orderDetail->status_order_detail == 'pending')
                                            <a href="{{ route('transactions_confirmation', $orderDetail->id) }}"
                                                class="btn btn-sm btn-success mt-3">Konfirmasi</a>
                                            <a href="{{ route('cancel_confirmation', $orderDetail->id) }}"
                                                class="btn btn-sm btn-outline-light mt-3" title="Batalkan layanan"><i
                                                    class="fa fa-times" aria-hidden="true"></i></a>
                                        @elseif (@$orderDetail->status_order_detail == 'cancel')
                                            <i class="fa fa-times-circle text-danger"></i>
                                            Dibatalkan
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#confirmDetail">Lihat</a> | <i
                                                class="fa fa-check-circle-o text-success" aria-hidden="true"></i>
                                            Terkonfirmasi
                                        @endif
                                    </div><!-- col-8 -->
                                </div>
                            @endforeach



                        </div><!-- card-body -->
                    </div><!-- card -->
                    <div class="card shadow-base bd-0 mt-3">
                        <div class="card-header bg-transparent pd-20">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Bukti Pembayaran Transaksi</h6>
                        </div><!-- card-header -->
                        <table class="table table-responsive mg-b-0 tx-12" id="table-payment">
                            <thead>
                                <tr class="tx-10">
                                    <th class="wd-10p pd-y-5">&nbsp;</th>
                                    <th class="pd-y-5">Nama Konsumen</th>
                                    <th class="pd-y-5">Status</th>
                                    <th class="pd-y-5">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$order->payments as $payment)
                                    <tr>
                                        <td class="pd-l-20">
                                            <img src="{{ $payment->images_payment ? asset('storage/' . $payment->images_payment) : 'https://picsum.photos/64' }}"
                                                class="wd-36 rounded" alt="Image">
                                        </td>
                                        <td>
                                            <a href=""
                                                class="tx-inverse tx-14 tx-medium d-block">{{ $payment->user->name }}</a>
                                            <span class="tx-11 d-block">Kode: {{ $payment->payment_code }}</span>
                                        </td>
                                        <td class="tx-12">
                                            @if ($payment->type == 'lunas')
                                                <span class="square-8 bg-success mg-r-5 rounded-circle"></span>
                                                {{ $payment->type }}
                                            @else
                                                <span class="square-8 bg-warning mg-r-5 rounded-circle"></span>
                                                {{ $payment->type }}
                                            @endif

                                        </td>
                                        @php
                                            $date = date_create($payment->created_at);
                                        @endphp
                                        <td>{{ date_format($date, 'd F Y') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div><!-- card -->
                    <div class="card shadow-base bd-0 mt-3">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h6 class="card-title tx-uppercase tx-12 mg-b-0">Summary</h6>
                            <span class="tx-12 tx-uppercase">
                                @if ($order->status_order == 'done')
                                    <i class="fa fa-check-circle-o text-success " aria-hidden="true"></i>
                                @elseif($order->status_order == 'cancel')
                                    <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-hourglass text-warning" aria-hidden="true"></i>
                                @endif
                                {{ $order->status_order }}
                            </span>
                        </div><!-- card-header -->
                        <div class="card-body">
                            <p class="tx-sm tx-inverse tx-medium mg-b-0">
                                Invoice: {{ $order->invoice_code }}
                            </p>
                            <p class="tx-12">{{ $order->created_at }}</p>
                            <div class="row align-items-center">
                                <div class="col-5 tx-sm tx-inverse tx-medium mg-b-0">
                                    Daftar Pesanan
                                </div>
                                <div class="col-4 tx-sm tx-inverse tx-medium mg-b-0">
                                    Jumlah/Durasi
                                </div>
                                <div class="col-3 tx-sm tx-inverse tx-medium mg-b-0">
                                    Total Price
                                </div>
                            </div>
                            @foreach ($order->orderDetails as $orderDetail)
                                <div class="row align-items-center">
                                    <div class="col-5 tx-12">{{ @$orderDetail->service->serviceCategory->name }} -
                                        {{ @$orderDetail->service->name }}</div>
                                    <!-- col-4 -->
                                    <div class="col-4 text-center">
                                        {{ @$orderDetail->quantity }}
                                    </div><!-- col-8 -->
                                    <div class="col-3 text-right">
                                        Rp. {{ number_format(@$orderDetail->total_price) }}
                                    </div><!-- col-8 -->
                                </div>
                            @endforeach
                            <div class="row align-items-center mt-2">
                                <div class="col-8 tx-sm tx-inverse tx-medium">Total</div><!-- col-4 -->
                                <div class="col-4 tx-sm tx-inverse tx-medium text-right">
                                    Rp {{ @number_format(@$order->orderDetails->sum('total_price')) }}
                                </div><!-- col-8 -->
                            </div><!-- row -->
                            {{-- <p class="tx-11 mg-b-0 mg-t-15">Deskripsi: Pembayaran sudah sesuai.</p> --}}
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
                            <p class="tx-sm tx-inverse tx-medium mg-b-0 tx-uppercase">{{ @$order->user->name }}</p>
                            <p class="tx-12">{{ @$order->user->address }}</p>
                            <div class="row align-items-center">
                                <div class="col-4 tx-12">No Telp</div><!-- col-4 -->
                                <div class="col-8">
                                    {{ @$order->user->number ?? '(Kosong)' }}
                                </div><!-- col-8 -->
                            </div><!-- row -->

                            <p class="tx-11 mg-b-0 mg-t-15">* Pastikan data konsumen sudah sesuai.</p>
                        </div><!-- card-body -->
                    </div><!-- card -->

                </div>

                <div class="col-md-12 col-xs-12 mt-3">
                    @if ($order->status_order == 'pending')
                        <a href="{{ route('transactions_cancel', $order->id) }}" class="btn btn-danger btn-with-icon">
                            <div class="ht-40 justify-content-between">
                                <span class="icon wd-40"><i class="fa fa-times"></i></span>
                                <span class="pd-x-15">Batalkan Transaksi</span>
                            </div>
                        </a>
                        @if ($countorderdetail)
                            <a class="btn btn-light btn-with-icon">
                                <div class="ht-40 justify-content-between">
                                    <span class="icon wd-40"><i class="fa fa-check"></i></span>
                                    <span class="pd-x-15">Konfirmasi Transaksi</span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('transactions_confirm', $order->id) }}"
                                class="btn btn-success btn-with-icon">
                                <div class="ht-40 justify-content-between">
                                    <span class="icon wd-40"><i class="fa fa-check"></i></span>
                                    <span class="pd-x-15">Konfirmasi Transaksi</span>
                                </div>
                            </a>
                        @endif
                    @endif

                </div>
            </div>

        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

    <!--  SEE CONFIRM TRANSACTIONS DETAIL -->
    <div id="confirmDetail" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                {{-- <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Konfirmasi Transaksi</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}
                <form id="form_add-category" method="POST" action="{{ route('categories_store') }}">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-valign-middle">
                            <tbody>
                                <tr>
                                    <td>
                                        <b>Tukang</b>
                                    </td>
                                    <td>Pak Budiono</td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Upah</b>
                                    </td>
                                    <td>Rp 25.000</td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Jumlah/Durasi Kerja</b>
                                    </td>
                                    <td>3 Jam</td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Deskripsi</b>
                                    </td>
                                    <td>Layanan Selesai Secepat Kilat</td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button"
                            class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
@endsection
@section('scripts')

    <script>
        $(function() {

            var table = $('#table-payment').DataTable({
                responsive: true,
                "searching": false,
                "ordering": false,
                "paging": false,
                "lengthChange": false,
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection

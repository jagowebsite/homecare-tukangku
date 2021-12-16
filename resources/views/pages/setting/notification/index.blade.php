@extends('layouts.main', [
'title' => 'Data Banners - Tukangku',
'menu' => 'chatting',
'submenu' => 'notification'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Setting</a>
            <span class="breadcrumb-item active">Menu Notification Order</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Semua Notification</h4>
        <p class="mg-b-0">Semua NOtifikasi Tukangku</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Notification</h6>
            <p class="mg-b-25 mb-4">Semua Notifikasi Layanan Homecare - Tukangku.</p>

            <div class="table-wrapper">
                <div class="row">
                    @isset($notifications)
                    @foreach ($notifications as $item)
                    <div class="col-12">
                        <a
                            href="{{ @$item->data['action']}}">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="my-0 py-0">{{ $item->data['msg'] }}</p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                        </a>
                    </div>
                    @endforeach
                    @endisset
                    <div class="col-12 d-flex justify-content-center">
                        {!! $notifications->links() !!}
                    </div>
                </div>
            </div><!-- table-wrapper -->
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

@endsection

@section('scripts')

@endsection

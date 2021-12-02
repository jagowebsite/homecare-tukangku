@extends('layouts.main', [
'title' => 'Chat - Tukangkita',
'menu' => 'chatting',
'submenu' => 'chat_cunsumen'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Konsumen</a>
            <span class="breadcrumb-item active">Chat Konsumen</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Chat Konsumen</h4>
        <p class="mg-b-0">Semua Chat Konsumen</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="col-4 mx-auto">

                <img src="{{url('/')}}/assets/img/coming_soon.png" alt="" width="100%">
            </div>
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

@section('scripts')

    <script>
     
    </script>
@endsection

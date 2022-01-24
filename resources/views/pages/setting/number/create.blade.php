@extends('layouts.main', [
  'title' => 'Tambah nomor whatsapp - Tukangku',
  'menu' => 'master',
  'submenu' => 'call_number'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <a class="breadcrumb-item" href="">Data nomor Whatsapp Owner</a>
            <span class="breadcrumb-item active">Tambah Whatsapp</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tambah Whatsapp</h4>
        <p class="mg-b-0">Tambah data whatsapp</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Tambah Whatsapp</h6>
            <p class="mg-b-25 mg-lg-b-50">Tambah Whatsapp Owner homecare - Tukangku.</p>

            <form action="{{ route('setting_number_store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="number">Nomor Whatsapp</label>
                        <input type="text" name="number" id="number" class="form-control" placeholder=""
                            value="{{ old('number') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="message">Pesan Default</label>
                        <textarea class="form-control" name="message" id="message"
                        rows="3">{{ old('message') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
        </div><!-- br-section-wrapper -->

    </div><!-- br-pagebody -->

@endsection

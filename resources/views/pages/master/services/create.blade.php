@extends('layouts.main', [
    'title' => 'Tambah Jasa - Tukangkita',
    'menu' => 'master',
    'submenu' => 'services'
  ])

@section('style')
    <link rel="stylesheet" href="{{ url('/') }}/vendor/image-uploader/src/image-uploader.css">
@endsection

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <a class="breadcrumb-item" href="">Data Jasa</a>
            <span class="breadcrumb-item active">Tambah Jasa</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tambah Jasa</h4>
        <p class="mg-b-0">Tambah data jasa layanan Tukangkita</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Tambah Jasa</h6>
            <p class="mg-b-25 mg-lg-b-50">Tambah jasa homecare - Tukangkita.</p>

            <form id="form-create" action="{{ route('services_store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Nama Jasa</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder=""
                            value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Kategori</label>
                        <select class="form-control" name="service_category_id" id="service_category_id">
                            <option value="">Choose...</option>
                            @isset($categories)
                                @foreach (@$categories as $item)
                                    <option value="{{ @$item->id }}">{{ @$item->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Gambar Jasa Layanan</label>
                        <div class="input-images"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="price">Harga</label>
                        <input type="text" name="price" id="price" class="form-control number-format" placeholder=""
                            value="{{ old('price') }}">
                    </div>
                </div>
                <div class=" row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Jenis Durasi Layanan</label>
                        <input type="text" name="type_quantity" id="type_quantity" class="form-control" placeholder=""
                            value="{{ old('type_quantity') }}">
                    </div>
                </div>
                <div class=" row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Keterangan</label>
                        <textarea class="form-control" name="description" id="description"
                            rows="3">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="form-check col-xs-12 col-md-6">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="status" id="status" value="1" checked>
                            Is Active
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
        </div><!-- br-section-wrapper -->

    </div><!-- br-pagebody -->

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ url('/') }}/vendor/image-uploader/dist/image-uploader.min.js"></script>
    <script>
        $('.input-images').imageUploader({
            imagesInputName: 'images',
        })
        $('#form-create').on('submit', function() {
            $('.number-format').number(true, 0, '.', '')
        })
    </script>
@endsection

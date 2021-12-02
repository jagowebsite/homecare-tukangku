@extends('layouts.main', [
  'title' => 'Tambah Banners - Tukangkita',
  'menu' => 'master',
  'submenu' => 'banners'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <a class="breadcrumb-item" href="">Data Banner</a>
            <span class="breadcrumb-item active">Tambah Banner</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tambah Banner</h4>
        <p class="mg-b-0">Tambah data banner</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Tambah Banner</h6>
            <p class="mg-b-25 mg-lg-b-50">Tambah banner homecare - Tukangkita.</p>

            <form action="{{ route('banners_store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="name">Nama Banner</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder=""
                            value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="url_asset">URL Banner</label>
                        <input type="text" name="url_asset" id="url_asset" class="form-control" placeholder=""
                            value="{{ old('url_asset') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="images">Image</label>
                        <input type="file" name="images" id="images" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-check  col-xs-12 col-md-6">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                                checked>
                            Is Active
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
        </div><!-- br-section-wrapper -->

    </div><!-- br-pagebody -->

@endsection

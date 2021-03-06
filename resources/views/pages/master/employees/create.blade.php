@extends('layouts.main', [
  'title' => 'Tambah Tukang - Tukangku',
  'menu' => 'master',
  'submenu' => 'employees'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <a class="breadcrumb-item" href="">Data Tukang</a>
            <span class="breadcrumb-item active">Tambah Tukang</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tambah Tukang</h4>
        <p class="mg-b-0">Tambah data tukang</p>
    </div>

    <div class="br-pagebody">
        <form id="form-create" action="{{ route('employees_store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="br-section-wrapper">
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Tambah Tukang</h6>
                <p class="mg-b-25 mg-lg-b-50">Tambah tukang homecare - Tukangku.</p>

                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Kategori</label>
                        <select class="form-control" name="service_category_id" id="service_category_id">
                            <option value="">Choose...</option>
                            @isset($categories)
                                @foreach (@$categories as $item)
                                    <option value="{{ @$item->id }}"
                                        {{ old('service_category_id') == @$item->id ? 'selected' : '' }}>{{ @$item->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder=""
                            value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="number">No Telp</label>
                        <input type="text" name="number" id="number" class="form-control" placeholder=""
                            value="{{ old('number') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="images">Image</label>
                        <input type="file" name="images" id="images" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address"
                            rows="3">{{ old('address') }}</textarea>
                    </div>
                </div>

                {{-- <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="status">Status</label>
                    <select class="form-control" name="" id="">
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                        <option>Meninggal</option>
                    </select>
                </div>
            </div> --}}

                <div class="row">
                    <div class="form-check  col-xs-12 col-md-6">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_ready" id="is_ready" value="1" checked>
                            Is Ready
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </div><!-- br-section-wrapper -->
        </form>
    </div><!-- br-pagebody -->

@endsection

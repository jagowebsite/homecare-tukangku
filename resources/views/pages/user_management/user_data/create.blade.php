@extends('layouts.main')

@section('style')
    <link href="{{ url('/') }}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Management User</a>
            <a class="breadcrumb-item" href="">User Data</a>
            <span class="breadcrumb-item active">Tambah</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tambah User</h4>
        <p class="mg-b-0">Tambah data user</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Tambah User</h6>
            <p class="mg-b-25 mg-lg-b-50">Tambah users homecare - Tukangku.</p>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder=""
                        aria-describedby="helpId" value="{{ old('email') }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder=""
                        aria-describedby="helpId" value="{{ old('user_name') }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder=""
                        aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password-confirm" class="form-control"
                        placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder=""
                        aria-describedby="helpId" value="{{ old('date_of_birth') }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">No Telp</label>
                    <input type="text" name="user_number" id="user_number" class="form-control" placeholder=""
                        aria-describedby="helpId" value="{{ old('user_number') }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Images</label>
                    <input type="file" name="user_image" id="user_image" class="form-control" placeholder=""
                        aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">KTP</label>
                    <input type="file" name="user_ktp" id="user_ktp" class="form-control" placeholder=""
                        aria-describedby="helpId">
                </div>
            </div>

            <button class="btn btn-primary mt-4">Submit</button>
        </div><!-- br-section-wrapper -->

    </div><!-- br-pagebody -->

@endsection

@section('scripts')

    <script>

    </script>
@endsection

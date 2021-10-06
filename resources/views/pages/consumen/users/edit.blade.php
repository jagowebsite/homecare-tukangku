@extends('layouts.main', [
'title' => 'Edit Pendaftaran - Tukangku',
'menu' => 'consumen_users',
'submenu' => ''
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Management User</a>
            <a class="breadcrumb-item" href="">User Data</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Edit User</h4>
        <p class="mg-b-0">Edit data user</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit User</h6>
            <p class="mg-b-25 mg-lg-b-50">Edit users homecare - Tukangku.</p>
            <form enctype="multipart/form-data" method="POST"
                action="{{ route('consumen_users_update', ['id' => @$user->id]) }}">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder=""
                            value="{{ old('email') ?? $user->email }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Name</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder=""
                            value="{{ old('user_name') ?? $user->name }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder=""
                            value="{{ old('date_of_birth') ?? $user->date_of_birth }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">No Telp</label>
                        <input type="text" name="user_number" id="user_number" class="form-control" placeholder=""
                            value="{{ old('user_number') ?? $user->user_number }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Images</label>
                        <input type="file" name="user_image" id="user_image" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">KTP</label>
                        <input type="file" name="user_ktp" id="user_ktp" class="form-control" placeholder="">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>

        </div><!-- br-section-wrapper -->
        <form enctype="multipart/form-data" method="POST"
            action="{{ route('users_change_password', ['id' => @$user->id]) }}">
            @csrf
            <div class="br-section-wrapper mt-3">
                <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Change Password</h6>
                <p class="mg-b-25 mg-lg-b-50">Change password user.</p>

                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">New Password</label>
                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control"
                            placeho>
                    </div>
                </div>

                <button class="btn btn-primary mt-4">Change Password</button>
            </div><!-- br-section-wrapper -->
        </form>
    </div><!-- br-pagebody -->

@endsection

@section('scripts')

@endsection

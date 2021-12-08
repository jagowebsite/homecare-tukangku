@extends('layouts.main', [
'title' => 'Profile - Tukangku',
'menu' => 'profile',
'submenu' => ''
])

@section('style')
    <link href="{{ url('/') }}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Profile</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Edit Profile</h4>
        <p class="mg-b-0">Edit profile</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Your Profile</h6>
            <p class="mg-b-25 mg-lg-b-50">Edit profile anda.</p>
            <form enctype="multipart/form-data" method="POST" action="{{ route('profile_update') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <div>
                            <img id="imgUp" src="{{ @$user->images ? asset('storage/' . $user->images) : 'https://picsum.photos/64' }}"
                                class="wd-150 rounded-circle py-2" alt="">
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Change Image</label>
                        <div>
                            <input type="file" name="user_image" id="user_image" placeholder="" aria-describedby="helpId" class="uploadFile">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Email</label>
                        <input type="text" name="email" id="email" class="form-control"
                            value="{{ old('email') ?? @$user->email }}" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name') ?? @$user->name }}" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">Tanggal Lahir</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                            value="{{ old('date_of_birth') ?? @$user->date_of_birth }}" placeholder=""
                            aria-describedby="helpId">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">No Telp</label>
                        <input type="text" name="number" id="number" class="form-control"
                            value="{{ old('number') ?? @$user->number }}" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="">KTP</label>
                        <input type="file" name="user_ktp" id="user_ktp" class="form-control" placeholder=""
                            aria-describedby="helpId">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>
        </div><!-- br-section-wrapper -->
        <div class="br-section-wrapper mt-3">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Change Password</h6>
            <p class="mg-b-25 mg-lg-b-50">Change password user.</p>
            <form enctype="multipart/form-data" method="POST"
            action="{{ route('users_change_password', ['id' => @Auth::user()->id]) }}">
            @csrf
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                    <label for="">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="" aria-describedby="helpId">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Change Password</button>
        </form>
        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->

@endsection

@section('scripts')

    <script>
        $(function() {
            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                console.log(uploadFile);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader)
                    return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                            document.getElementById("imgUp").src = this.result;
                    }
                }

            });
        });
        $(function() {

            $('#datatable2').DataTable({
                bLengthChange: false,
                searching: false,
                responsive: true
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

        });
    </script>
@endsection

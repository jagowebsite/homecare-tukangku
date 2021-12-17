@extends('layouts.main', [
  'title' => 'Edit Rekening - Tukangku',
  'menu' => 'master',
  'submenu' => 'rekening'
])

@section('content')
    @include('layouts.alert')
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="">Homecare</a>
            <a class="breadcrumb-item" href="">Master</a>
            <a class="breadcrumb-item" href="">Data Rekening Owner</a>
            <span class="breadcrumb-item active">Edit Rekening</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Edit Rekening</h4>
        <p class="mg-b-0">Edit data Rekening</p>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Rekening</h6>
            <p class="mg-b-25 mg-lg-b-50">Edit Rekening Owner homecare - Tukangku.</p>

            <form action="{{ route('account_update', $account->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="account_name">Nama Akun</label>
                        <input type="text" name="account_name" id="account_name" class="form-control" placeholder=""
                            value="{{ old('account_name') ?? $account->account_name}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="account_number">Nomer Rekening</label>
                        <input type="text" name="account_number" id="account_number" class="form-control" placeholder=""
                            value="{{ old('account_number') ?? $account->account_number}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                        <label for="bank_name">Nama Bank</label>
                        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder=""
                            value="{{ old('bank_name') ?? $account->bank_name}}">
                    </div>
                </div>
               
                <div class="row">
                    <div class="form-check  col-xs-12 col-md-6">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                            {{ $account->is_active == '1' ? 'checked' : '' }}>
                            Is Active
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
        </div><!-- br-section-wrapper -->

    </div><!-- br-pagebody -->

@endsection

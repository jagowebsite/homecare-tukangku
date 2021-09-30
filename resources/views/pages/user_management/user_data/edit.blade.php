@extends('layouts.main')

@section('style')
    <link href="{{url('/')}}/assets/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
@endsection

@section('content')

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

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">Email</label>
              <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">Name</label>
              <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">Tanggal Lahir</label>
              <input type="date" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">No Telp</label>
              <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">Images</label>
              <input type="file" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">KTP</label>
              <input type="file" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        
        <button class="btn btn-primary mt-4">Simpan</button>
    </div><!-- br-section-wrapper -->

    <div class="br-section-wrapper mt-3">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Change Password</h6>
        <p class="mg-b-25 mg-lg-b-50">Change password user.</p>

        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">Password</label>
              <input type="password" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              <label for="">New Password</label>
              <input type="password" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
        </div>
        
        <button class="btn btn-primary mt-4">Change Password</button>
    </div><!-- br-section-wrapper -->
  </div><!-- br-pagebody -->
    
@endsection

@section('scripts')

<script>
    $(function(){

      $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
      });

      // Select2
      $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
</script>
@endsection
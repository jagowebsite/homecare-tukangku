@extends('layouts.main')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="">Homecare</a>
      <a class="breadcrumb-item" href="">Master</a>
      <a class="breadcrumb-item" href="">Data Banner</a>
      <span class="breadcrumb-item active">Edit Banner</span>
    </nav>
  </div><!-- br-pageheader -->
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5">Edit Banner</h4>
    <p class="mg-b-0">Edit data banner</p>
  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Edit Banner</h6>
        <p class="mg-b-25 mg-lg-b-50">Edit banner homecare - Tukangku.</p>

        <form action="" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                <label for="">Nama Banner</label>
                <input type="text" name="" id="" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                <label for="">URL Banner</label>
                <input type="text" name="" id="" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12 col-md-6">
                <label for="">Image</label>
                <input type="file" name="" id="" class="form-control" placeholder="">
                </div>
            </div>

            <div class="row">
                <div class="form-check  col-xs-12 col-md-6">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                    Is Active
                </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>
    </div><!-- br-section-wrapper -->
    
  </div><!-- br-pagebody -->
    
@endsection
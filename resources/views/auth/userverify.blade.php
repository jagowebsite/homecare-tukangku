@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

        <div class="login-wrapper wd-700  pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal"></span> Tukangku <span
                    class="tx-normal"></span></div>
            <div class="tx-center mg-b-60">Professional Homecare</div>
            @if ($message = Session::get('verified'))
                <div class="card border-0">
                    {{-- <div class="card-header">Verification Account</div> --}}
                    <div class="card-body text-success text-center">
                        Your Account Has Been Activated
                    </div>
                </div>
            @elseif ($message = Session::get('status'))
                <div class="card border-0">
                    {{-- <div class="card-header">Reset Password</div> --}}
                    <div class="card-body text-success text-center">
                        Your Password Has been Reset</a>
                    </div>
                </div>
            @else
                <div class="card border-0">
                    <div class="card-body text-danger text-center">
                        {{ __('This Page is no longer availabe') }}
                    </div>
                </div>

            @endif

            <div class="mg-t-60 tx-center">
                &copy; Tukangku 2021
                {{-- <a href="" class="tx-info">Sign Up</a> --}}
            </div>
        </div><!-- login-wrapper -->
    </div>

@endsection

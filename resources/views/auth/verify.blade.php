@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

        <div class="login-wrapper wd-700  pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal"></span> Tukangkita <span
                    class="tx-normal"></span></div>
            <div class="tx-center mg-b-60">Professional Homecare</div>
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>

            <div class="mg-t-60 tx-center">
                &copy; Tukangkita 2021
                {{-- <a href="" class="tx-info">Sign Up</a> --}}
            </div>
        </div><!-- login-wrapper -->
    </div>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

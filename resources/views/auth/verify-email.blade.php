@extends('layouts.user.new_layout')
@section('content')
<section class="loginWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="{{ asset("/img/logo.png") }}" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="{{ asset("/img/img_3.jpg")}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="form">
                            <p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>
                            <x-jet-validation-errors class="mb-4 errorMsg" />
                            @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 successMsg">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                            @endif
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <input type="submit" id="next" value=" {{ __('Resend Verification Email') }}"
                                            class="loginBtn">
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="submit" value=" {{ __('Logout') }}" class="loginBtn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
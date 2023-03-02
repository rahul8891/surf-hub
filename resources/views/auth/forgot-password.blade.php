@extends('layouts.user.new_layout')
@section('content')
<section class="loginWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="img/logo.png" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="img/img_1.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="form">
                            <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </p>
                            <!-- <x-jet-validation-errors class="mb-4 errorMsg" /> -->
                            @if (session('status'))
                            <div class="mb-4 successMsg">
                                {{ session('status') }}
                            </div>
                            @endif
                            <form method="POST" name="forgot_password" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="Email" autofocus
                                            required>
                                        <span><img src="img/email.png" alt=""></span>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="next1" value=" {{ __('Reset My Password') }}"
                                        class="loginBtn">
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('login') }}">{{ __('Back to Login') }}</a>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
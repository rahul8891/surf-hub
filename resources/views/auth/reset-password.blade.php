@extends('layouts.guest_user')
@section('content')
<section class="loginWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="{{ asset("/img/logo_2.png") }}" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="{{ asset("/img/img_3.jpg")}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="form">
                            <p>
                                {{ __('Reset your password.Just enter your new and confirm password') }}
                                <x-jet-validation-errors class="mb-4 errorMsg" />
                            <form method="POST" name="reset_password" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email',$request->email) }}" placeholder="Email"
                                            autofocus required readonly>
                                        <span><img src="{{ asset("/img/email.png")}}" alt=""></span>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Password" autocomplete="new-password" required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" placeholder="Confirm Password " required
                                            autocomplete="new-password">
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <input type="submit" id="next1" value="{{ __('Reset Password') }}" class="loginBtn">
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
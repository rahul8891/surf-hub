@extends('layouts.user.user')
@section('content')
<!--<section class="loginWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="img/logo_2.png" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="img/img_1.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-4">
                        <div class="form">
                            <h3>Welcome to SurfHub’s Login</h3>
                            <p>Log In or Sign Up below to start your own free Storage Hub of all your personal surf
                                videos and photos! Follow your friends and enjoy the best search filters available to
                                view surf footage from around the world!!</p>
                            <p class="loginTxt">Login... To see it in action.</p>
                            <x-jet-validation-errors class="mb-4 errorMsg" />
                            @if (session('status'))
                            <div class="mb-4 successMsg">
                                {{ session('status') }}
                            </div>
                            @endif
                            <form method="POST" name="login" id=" login" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="text" class="form-control" id="email" name="email"
                                               value="{{ old('email') }}" placeholder="Email / User Name" autofocus
                                               required>
                                        <span><img src="img/email.png" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="Password" autocomplete="current-password" required>
                                        <span><img src="img/lock.png" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cstm-check pos-rel">
                                        <input type="checkbox" id="Keep" class="form-checkbox" name="remember" />
                                        <label for="Keep" class="">{{ __('Keep me logged in.')}}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" id="next1" value="{{ __('Login') }}" class="loginBtn">
                                </div>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
                                    @endif
                                </div>
                                <a href="{{ route('register') }}"
                                   class="signupBtn">{{ __('Sign Up for New User?') }}</a>
                        </div>
                        </form>
                    </div>
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="img/filterRightIcon.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->

<div class="login-wrap">
    <div class="container">
        <h1><span class="blue-txt">SurfHub’s</span> Login</h1>
        <p>Log In or Sign Up below to start your own free Storage
            Hub of all your personal surf videos and photos!
            Follow your friends and enjoy the best search
            filters available to view surf footage from
            around the world!!</p>
        @if (session('status'))
        <div class="mb-4 successMsg">
            {{ session('status') }}
        </div>
        @endif
        <form method="POST" name="login" id=" login" action="{{ route('login') }}">
            @csrf
            <div>
                <input type="text" class="form-control user-icon" id="email" name="email" value="{{ old('email') }}" autofocus
                       required>
            </div>
            <div>
                <input type="password" class="form-control password-icon" id="password" name="password"
                       autocomplete="current-password" required>
            </div>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="logggedIn" name="remember">
                    <label class="form-check-label" for="logggedIn">Keep me logged in.</label>
                </div>
                <a href="/forgot-password" class="blue-txt frgt-pswd">Forgot Password?</a>

            </div>
            <input type="submit" class="btn blue-btn w-100" value="LOGIN">
            <div class="sign-up-anchor">For New User ! <a href="/register" class="blue-txt">Sign Up</a></div>
        </form>
    </div>
</div>

@endsection
@extends('layouts.guest_user')
@section('content')
<section class="loginWrap registrationWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="img/logo_2.png" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-end text-center">
                        <img src="img/img_3.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form">
                                <h2>Registration</h2>
                                <div class="row">
                                    <span id="remove-img" class="reset-img notDisplayed"><img src="img/close.png"
                                            id="img-remove" width="18px" alt=""></span>
                                    <div class="col-md-6">
                                        <div class="d-flex uploadBtnMainWrap align-items-center form-group">
                                            <div class="upload-btn-wrapper ">
                                                <button class="">
                                                    <img src="img/image-file.png" id="category-img-tag" alt="">
                                                </button>
                                                <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputFile"
                                                    name="profile_photo_name" />
                                            </div>
                                            <label class="mb-0 pl-1">Upload Profile Pic</label>
                                        </div>
                                        <span id="imageError" class="notDisplayed required">Please upload files having
                                            extensions: jpg, jpeg, png</span>
                                    </div>
                                    <!-- Error display -->
                                    <div class="col-md-6">
                                        <x-jet-validation-errors class="errorMsg" />
                                        @if (session('status'))
                                        <div class="successMsg">
                                            {{ __('Registration Successfull, Please verify the email sent on your email address.') }}
                                        </div>
                                        @endif
                                    </div>
                                    <!-- End Error display -->
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input class="form-control" type="text" name="first_name"
                                                    value="{{ old('first_name') }}" autocomplete="first_name"
                                                    placeholder="First Name" required>
                                                <span><img src="img/user-grey.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Last Name" class="form-control"
                                                    name="last_name" value="{{ old('last_name') }}"
                                                    autocomplete="last_name">
                                                <span><img src="img/user-grey.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" class="form-control" placeholder="User Name"
                                                    name="name" value="{{ old('name') }}" required autocomplete="name">
                                                <span><img src="img/user-grey.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="email" placeholder="Email" class="form-control"
                                                    name="email" value="{{ old('email') }}" required>
                                                <span><img src="img/email.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Phone No." class="form-control"
                                                    name="phone" value="{{ old('phone') }}" autocomplete="phone">
                                                <span><img src="img/phone1.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="country_id" required>
                                                    <option value="">-- Country --</option>
                                                    @foreach($countries as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ old('country_id') == $value->id ? "selected" : "" }}>
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="arrow">
                                                    <img src="img/select-downArrow.png" alt="">
                                                </span>
                                                <span class="first-icon"><img src="img/url.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="language" required>
                                                    <option value="">-- Preferred Language --</option>
                                                    @foreach($language as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('language') == $key ? "selected" : "" }}>{{ $value }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="arrow">
                                                    <img src="img/select-downArrow.png" alt="">
                                                </span>
                                                <span class="first-icon"><img src="img/global.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="account_type" required>
                                                    <option value="">-- Account Type --</option>
                                                    @foreach($accountType as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('account_type') == $key ? "selected" : "" }}>{{ $value }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="arrow">
                                                    <img src="img/select-downArrow.png" alt="">
                                                </span>
                                                <span class="first-icon"><img src="img/user-grey.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Facebook Account" class="form-control"
                                                    name="facebook" value="{{ old('facebook') }}"
                                                    autocomplete="facebook">
                                                <span><img src="img/facebook-app-symbol.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Instagram Account" class="form-control"
                                                    name="instagram" value="{{ old('instagram') }}"
                                                    autocomplete="instagram">
                                                <span><img src="img/instagram-grey.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="password" placeholder="Password" class="form-control"
                                                    value="admin" name="password" autocomplete="new-password" required>
                                                <span><img src="img/lock.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="local_beach_break_id" required>
                                                    <option value="">-- Local Beach / Break --</option>
                                                    <option value="1"> Rolen Beach </option>
                                                </select>
                                                <span class="arrow">
                                                    <img src="img/select-downArrow.png" alt="">
                                                </span>
                                                <span class="first-icon"><img src="img/location.png" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="password" placeholder="Confirm Password"
                                                    class="form-control" value="admin" name="password_confirmation"
                                                    autocomplete="new-password" required>
                                                <span><img src="img/lock.png" alt=""></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="radioWrap">
                                                <input type="radio" id="test1" name="terms" required>
                                                <label for="test1">{{ __('Accept legal') }} <a
                                                        href="javaScript:void(0)"><span>{{ __('terms and conditions.') }}</span></a></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" id="next" value="Signup" class="loginBtn">
                                        </div>
                                        <div class="alreadyAccount">
                                            {{ __('Already have an account?') }} <a
                                                href="{{ route('login') }}">{{ __('Sign in') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-end text-center">
                                        <img src="img/filterRightIcon.jpg" class="img-fluid width-240" alt="">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
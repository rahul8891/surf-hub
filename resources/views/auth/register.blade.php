@extends('layouts.guest_user')
@section('content')

<section class="loginWrap registrationWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="text-center">
                <a href="{{ url('/') }}"><img src="{{ asset("/img/logo_2.png")}}" alt="" class="img-fluid logo"></a>
            </div>
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-end text-center">
                        <img src="img/img_3.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-8">
                        <form method="POST" id="register" name="register" action="{{ route('register') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form">
                                <h2>Registration</h2>
                                <div class="row">
                                    <span id="remove-img" class="reset-img notDisplayed">
                                        <img src="{{ asset("/img/close.png")}}" id="img-remove" width="14px" alt="">
                                    </span>
                                    <div class="col-md-6">
                                        <div class="d-flex uploadBtnMainWrap align-items-center form-group">
                                            <div class="upload-btn-wrapper ">
                                                <button class="">
                                                    <img src="{{ asset("/img/image-file.png")}}" id="category-img-tag"
                                                        alt="">
                                                </button>
                                                <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputFile"
                                                    name="profile_photo_name" />

                                                <input type="hidden" accept=".png, .jpg, .jpeg" id="imagebase64"
                                                    name="profile_photo_blob" />

                                            </div>
                                            <label class="mb-0 pl-1">Upload Profile Pic</label>

                                        </div>
                                        <span id="imageError" class="notDisplayed required">{{ __('Please upload files having
                                            extensions: jpg, jpeg, png') }}</span>
                                        @error('profile_photo_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- <input type="file" name="upload" id="upload" /> -->
                                    <!-- Error display -->
                                    <div class="col-md-6">
                                        <!-- <x-jet-validation-errors class="errorMsg" /> -->
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
                                                    value="{{ old('first_name') }}" minlength="3"
                                                    autocomplete="first_name" placeholder="First Name" required>
                                                <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span>
                                                @error('first_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Last Name" class="form-control"
                                                    name="last_name" value="{{ old('last_name') }}" minlength="3"
                                                    autocomplete="last_name" required>
                                                <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span>
                                                @error('last_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" class="form-control" placeholder="User Name"
                                                    name="user_name" value="{{ old('user_name') }}" minlength="5"
                                                    maxlength="25" required autocomplete="user_name">
                                                <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span>
                                                @error('user_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Email" class="form-control" name="email"
                                                    value="{{ old('email') }}" autocomplete="email" required>
                                                <span><img src="{{ asset("/img/email.png")}}" alt=""></span>
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap">
                                                <select
                                                    class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    name="country_id" required>
                                                    <option value="" data-phone="">-- Country --</option>
                                                    @foreach($countries as $key => $value)
                                                    <option value="{{ $value->id }}" data-phone="{{$value->phone_code}}"
                                                        {{ old('country_id') == $value->id ? "selected" : "" }}>
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="arrow">
                                                    <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                </span>
                                                <span class="first-icon"><img src="{{ asset("/img/url.png")}}"
                                                        alt=""></span>
                                                @error('country_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Phone No." class="form-control phone"
                                                    name="phone" value="{{ old('phone') }}" minlength="10"
                                                    maxlength="15" autocomplete="phone" required>
                                                <span><img src="{{ asset("/img/phone1.png")}}" alt=""></span>
                                                @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <!-- <div class="text-danger">
                                            <span id="valid-msg" class="hide">✓
                                                Valid</span>
                                            <span id="error-msg" class="hide"></span>
                                        </div> -->
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control select2 select2-hidden-accessible language"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    name="language" required>
                                                    <option value="">-- Preferred Language --</option>
                                                    @foreach($language as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('language') == $key ? "selected" : "" }}>{{ $value }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span class="arrow">
                                                    <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                </span>
                                                <span class="first-icon"><img src="{{ asset("/img/global.png")}}"
                                                        alt=""></span>
                                                @error('language')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <select
                                                    class="form-control select2 select2-hidden-accessible accountType"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    name="account_type" required>
                                                    <option value="">-- Account Type --</option>
                                                    @foreach($accountType as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('account_type') == $key ? "selected" : "" }}>
                                                        {{ $value }}
                                                    </option>
                                                    @endforeach
                                                </select>

                                                <span class="arrow">
                                                    <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                </span>
                                                <span class="first-icon"><img src="{{ asset("/img/user-grey.png")}}"
                                                        alt=""></span>
                                                @error('language')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="password" id="password" placeholder="Password"
                                                    class="form-control" name="password" autocomplete="new-password"
                                                    required>
                                                <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="password" placeholder="Confirm Password"
                                                    class="form-control" name="password_confirmation"
                                                    autocomplete="new-password" required>
                                                <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="selectWrap pos-rel">
                                                <!-- <select
                                                    class="form-control select2 select2-hidden-accessible local_beach_break"
                                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                    id="local_beach_break_id" name="local_beach_break_id" required>
                                                    <option value=""> --Select Beach Break-- </option>
                                                    @foreach($beachBreaks as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ old('local_beach_break_id') == $value->id ? "selected" : "" }}>
                                                        {!! $value->beach_name.'
                                                        '.$value->break_name.', '.$value->city_region.',
                                                        '.$value->state.', '.$value->country
                                                        !!}</option>
                                                    @endforeach
                                                </select> -->
                                                <input type="text" value="{{ old('local_beach_break')}}"
                                                    name="local_beach_break" data-beachID=""
                                                    placeholder="Search Beach Break "
                                                    class="form-control  @error('local_beach_break') is-invalid @enderror search-box">

                                                <input type="hidden" name="local_beach_break_id"
                                                    id="local_beach_break_id" class="form-control">

                                                <div class="auto-search search1" id="country_list"></div>

                                                <span class="first-icon"><img src="{{ asset("/img/location.png")}}"
                                                        alt=""></span>
                                                @error('local_beach_break')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Facebook Account Link"
                                                    class="form-control" name="facebook" value="{{ old('facebook') }}"
                                                    autocomplete="facebook">
                                                <span><img src="{{ asset("/img/facebook-app-symbol.png")}}"
                                                        alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group pos-rel">
                                            <div class="inputWrap">
                                                <input type="text" placeholder="Instagram Account Link"
                                                    class="form-control" name="instagram" value="{{ old('instagram') }}"
                                                    autocomplete="instagram">
                                                <span><img src="{{ asset("/img/instagram-grey.png")}}" alt=""></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="radioWrap">
                                                <input type="radio" id="test1" name="terms" value="true" required>
                                                <label for="test1">{{ __('Accept legal') }} <a href="javaScript:void(0)"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal"><span>{{ __('terms and conditions.') }}</span></a></label>
                                            </div>
                                            @error('terms')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" id="next1" value="Signup" class="loginBtn">
                                        </div>
                                        <div class="alreadyAccount">
                                            {{ __('Already have an account?') }} <a
                                                href="{{ route('login') }}">{{ __('Sign in') }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-end text-center">
                                        <img src="{{ asset("/img/filterRightIcon.jpg")}}" class="img-fluid width-240"
                                            alt="">
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
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}"> &nbsp; Crop
                    Image
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img alt="" src="{{ asset("/img/close.png")}}">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div id="image"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center justify-content-center">
                <button class="btn btn-success crop_image">Crop</button>
            </div>
        </div>
    </div>
</div>
<!-- @include('layouts/models/image_crop') -->
@include('layouts/models/terms-and-conditions')
@endsection
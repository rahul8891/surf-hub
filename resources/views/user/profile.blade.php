@extends('layouts.user.user')
@section('content')
<div class="feedHubNav ">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <ul class="mb-0 pl-0">
                    <li class="hover-no">
                        <a href="javascript:void(0);">My Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>



<section class="loginWrap changePswd registrationWrap">
    <div class="innerWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="formWrap">

                        <div class="profileImgDetail">
                            <div class="imgWrap">
                                <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="">
                            </div>
                            <div class="btnWrap">
                                <h3>{{__(ucwords(Auth::user()->user_profiles->first_name .' '. Auth::user()->user_profiles->last_name))}}
                                </h3>
                                <!-- <button>Edit</button> -->
                            </div>
                        </div>
                        <form method="POST" name="update_profile" action="{{ route('storeProfile') }}">
                            @csrf
                            <div class="innerForm">
                                <div class="row">
                                    @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible" id="msg" role="alert">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ ucfirst($error) }}</li>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible" role="alert" id="msg">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ ucfirst($message) }}
                                    </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span> User
                                            Name</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="user_name"
                                            value="{{ old('user_name',Auth::user()->user_name) }}"
                                            class="form-control @error('user_name') is-invalid @enderror" readonly>
                                        @error('user_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/email.png")}}" alt=""></span> Email</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="email" value="{{ old('email',Auth::user()->email) }}"
                                            class="form-control @error('email') is-invalid @enderror" readonly>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span> First
                                            Name</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="first_name"
                                            value="{{ old('first_name',Auth::user()->user_profiles->first_name) }}"
                                            class="form-control @error('first_name') is-invalid @enderror">
                                        @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span> Last
                                            Name</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="last_name"
                                            value="{{ old('last_name',Auth::user()->user_profiles->last_name) }}"
                                            class="form-control @error('last_name') is-invalid @enderror">
                                        @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="col-md-3 col-xl-3" id="id-error">
                                        <label for="last_name" class="error" generated="true"></label>
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/phone1.png")}}" alt=""></span> Phone
                                            No.</label>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="phone"
                                            value="{{ old('phone',Auth::user()->user_profiles->phone)}}"
                                            class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 col-xl-3">
                                        <span for="phone" class="validation_error_message error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/url.png")}}" alt=""></span>
                                            Country</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">

                                        <select class="form-control @error('country_id') is-invalid @enderror"
                                            name="country_id" required>
                                            <option value="">-- Country --</option>
                                            @foreach($countries as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ ($value->id == Auth::user()->user_profiles->country_id) ? "selected" : "" }}>
                                                {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="arrow">
                                            <img src="{{ asset("/img/select-downArrow.png") }}" alt="">
                                        </span> -->
                                        @error('country_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                        <!-- <span class="arrow">
                                        <img src="{{ asset("/img/select-downArrow.png") }}" alt="">
                                    </span> -->


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/global.png")}}" alt=""></span>
                                            Preferred
                                            Language.</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <!-- <input type="text" value="English" class="form-control"> -->
                                        <select class="form-control @error('language') is-invalid @enderror"
                                            name="language" required>
                                            <option value="">-- Preferred Language --</option>
                                            @foreach($language as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ ($key == Auth::user()->user_profiles->language) ? "selected" : "" }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('language')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/location.png")}}" alt=""></span>
                                            Local
                                            Beach
                                            /
                                            Break</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <!-- <input type="text" value="Local beach" class="form-control"> -->
                                        <select class="form-control @error('local_beach_break_id') is-invalid @enderror"
                                            name="local_beach_break_id" required>
                                            <option value=""> --Select Beach Break-- </option>
                                            @foreach($beachBreaks as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ ($value->id == Auth::user()->user_profiles->local_beach_break_id) ? "selected" : "" }}>
                                                {!! $value->beach_name.'
                                                '.$value->break_name.', '.$value->city_region.',
                                                '.$value->state.', '.$value->country
                                                !!}</option>
                                            @endforeach
                                        </select>
                                        @error('local_beach_break_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span>
                                            Account
                                            Type
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <select class="form-control @error('account_type') is-invalid @enderror"
                                            name="account_type" required>
                                            <option value="">-- Account Type --</option>
                                            @foreach($accountType as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ ($key == Auth::user()->account_type) ? "selected" : "" }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('account_type')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/instagram-grey.png")}}" alt=""></span>
                                            Instagram
                                            Account
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="instagram"
                                            value="{{ old('instagram',Auth::user()->user_profiles->instagram )}}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/facebook-app-symbol.png")}}" alt="">
                                            </span>
                                            Facebook Account
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="facebook"
                                            value="{{ old('facebook',Auth::user()->user_profiles->facebook )}}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="submit" id="next1" value="Update" class="loginBtn">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <img src="{{ asset("/img/logoMedium.png")}}" alt="" class="logo">
                    </div>
                </div>
                <div class="col-lg-3   text-center">
                    <div class="adWrap">
                        <img src="{{ asset("/img/add1.png")}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
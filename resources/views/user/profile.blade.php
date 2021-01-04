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
                            <!-- <div class="imgWrap">
                                @if($user->profile_photo_path)
                                <img src="{{ asset('storage/'.$user->profile_photo_path) }}" class="img-fluid image"
                                    alt="" id="category-img-tag">
                                @else
                                <img src="{{ asset("/img/profile1.jpg")}}" class="img-fluid image" alt=""
                                    id="category-img-tag">
                                @endif
                            </div> -->
                            <div class="imgWrap upload-btn-wrapper ">
                                @if($user->profile_photo_path)
                                <img src="{{ asset('storage/'.$user->profile_photo_path) }}" class="img-fluid image"
                                    alt="" id="category-img-tag">
                                @else
                                <img src="{{ asset("/img/profile1.jpg")}}" class="img-fluid image" alt=""
                                    id="category-img-tag">
                                @endif
                                <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputProfileFile"
                                    name="profile_photo_name" />
                                <input type="hidden" accept=".png, .jpg, .jpeg" id="imagebase64"
                                    name="profile_photo_blob" />

                            </div>
                            <div class="btnWrap">
                                <h3>{{__(ucwords($user->user_profiles->first_name .' '. $user->user_profiles->last_name))}}
                                </h3>
                                <button>Edit</button>
                            </div>
                        </div>
                        <span id="imageError" class="notDisplayed required">{{ __('Please upload files having
                                            extensions: jpg, jpeg, png') }}</span>
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

                                    <div id="error"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span> User
                                            Name</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="user_name"
                                            value="{{ old('user_name',$user->user_name) }}"
                                            class="form-control @error('user_name') is-invalid @enderror" readonly
                                            required>
                                        @error('user_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="user_name" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/email.png")}}" alt=""></span>
                                            Email</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="email" value="{{ old('email',$user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror" readonly required>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="email" class="error" generated="true"></label>
                                        </div>
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
                                            value="{{ old('first_name',$user->user_profiles->first_name) }}"
                                            class="form-control @error('first_name') is-invalid @enderror" required>
                                        @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="first_name" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/user-grey.png")}}" alt=""></span> Last
                                            Name</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <input type="text" name="last_name"
                                            value="{{ old('last_name',$user->user_profiles->last_name) }}"
                                            class="form-control @error('last_name') is-invalid @enderror" required>
                                        @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="last_name" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/url.png")}}" alt=""></span>
                                            Country</label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <select class="form-control @error('country_id') is-invalid @enderror country"
                                            name="country_id" required>
                                            <option value="" data-phone="">-- Country --</option>
                                            @foreach($countries as $key => $value)
                                            <option value="{{ $value->id }}" data-phone="{{$value->phone_code}}"
                                                {{ ($value->id == $user->user_profiles->country_id) ? "selected" : "" }}>
                                                {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="country_id" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/phone1.png")}}" alt=""></span> Phone
                                            No.</label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="phoneWrap">
                                        <input type="text" placeholder="ICC" class="form-control telephone_prefix phone" 
                                            readonly name="telephone_prefix" 
                                            value="{{ old('telephone_prefix',$user->user_profiles->icc) }}">
                                        <input type="text" name="phone"
                                            value="{{ old('phone',$user->user_profiles->phone)}}"
                                            class="form-control @error('phone') is-invalid @enderror phone_number"
                                            minlength="8" maxlength="15" required>
                                        @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                        <div class="id-error" id="id-error">
                                            <label for="phone" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/global.png")}}" alt=""></span>
                                            Preferred Language
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        <!-- <input type="text" value="English" class="form-control"> -->
                                        <select class="form-control @error('language') is-invalid @enderror"
                                            name="language" required>
                                            <option value="">-- Preferred Language --</option>
                                            @foreach($language as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ ($key == $user->user_profiles->language) ? "selected" : "" }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <!-- <span class="arrow">
                                            <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                        </span> -->
                                        @error('language')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="language" class="error" generated="true"></label>
                                        </div>
                                    </div>
                                </div>
                                <!-- This -->
                                <div class="row">
                                    <div class="col-md-4 col-xl-3 pr-0">
                                        <label>
                                            <span><img src="{{ asset("/img/location.png")}}" alt=""></span>
                                            Local Beach / Break
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xl-9">
                                        @php
                                        $beachBreaksValue = ($user->user_profiles->beach_breaks) ?
                                        $user->user_profiles->beach_breaks->beach_name.','.$user->user_profiles->beach_breaks->break_name.
                                        ','.$user->user_profiles->beach_breaks->city_region.','.$user->user_profiles->beach_breaks->state.
                                        ','.$user->user_profiles->beach_breaks->country : '';
                                        @endphp

                                        <!-- <input type="text" value="" name="local_beach_break"
                                            placeholder="Search Beach Break " class="form-control search-box"> -->

                                        <input type="text" value="{{ old('local_beach_break',$beachBreaksValue)}}"
                                            name="local_beach_break" data-beachID="" placeholder="Search Beach Break "
                                            class="form-control  @error('local_beach_break') is-invalid @enderror search-box">

                                        <input type="hidden"
                                            value="{{ old('local_beach_break_id',$user->user_profiles->local_beach_break_id)}}"
                                            name="local_beach_break_id" id="local_beach_break_id" class="form-control">

                                        <div class="auto-search search1" id="country_list"></div>
                                        @error('local_beach_break')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="local_beach_break" class="error" generated="true"></label>
                                        </div>
                                        <!-- <input type="text" value="{{ old('local_beach_break')}}"
                                            name="local_beach_break" data-beachID="" placeholder="Search Beach Break "
                                            class="form-control  @error('local_beach_break') is-invalid @enderror">

                                        @error('local_beach_break')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="local_beach_break" class="error" generated="true"></label>
                                        </div> -->
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
                                                {{ ($key == $user->account_type) ? "selected" : "" }}>
                                                {{ $value }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('account_type')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="id-error" id="id-error">
                                            <label for="account_type" class="error" generated="true"></label>
                                        </div>
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
                                            value="{{ old('instagram',$user->user_profiles->instagram )}}"
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
                                            value="{{ old('facebook',$user->user_profiles->facebook )}}"
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
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}"> &nbsp; Crop
                    Image
                </h5>
                <button type="button" class="close1" data-dismiss="modal" aria-label="Close">
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
                <button class="btn btn-success crop_profile_image">Crop</button>
            </div>
        </div>
    </div>
</div>
@endsection

<form method="POST" id="register" name="register" action="{{ route('register') }}"
      enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="upload-photo">
                <div>
                    <!--<button class="">-->
                                                    <img src="" id="category-img-tag"
                                                         alt="">
                                                <!--</button>-->
                    <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputFile" name="profile_photo_name">
                    <input type="hidden" accept=".png, .jpg, .jpeg" id="imagebase64" name="profile_photo_blob" />
                </div>
                <span class="align-middle d-inline-block ms-3">Upload Profile Pic</span>
            </div>
            <span id="imageError" class="notDisplayed required">{{ __('Please upload files having
                                            extensions: jpg, jpeg, png') }}</span>
            @error('profile_photo_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="Business Name (Optional)" name="business_name"
                   value="" minlength="3" autocomplete="business_name">
            @error('business_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <!-- <div class="white-bg photographer-icon">
                <select class="form-select " name="photographer_type" required>
                    <option value="">Photographer Type</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                @error('photographer_type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="Contact First Name" name="first_name"
                   value="{{ old('first_name') }}" minlength="3" autocomplete="first_name" required>
            @error('first_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="Contact Last Name" name="last_name" value="{{ old('last_name') }}" minlength="3"
                   autocomplete="last_name" required>
            @error('last_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="User Name" name="user_name" value="{{ old('user_name') }}" minlength="5"
                   maxlength="25" required autocomplete="user_name">
            @error('user_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="email" class="form-control email-icon" placeholder="Email" name="email"
                   value="{{ old('email') }}" autocomplete="email" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="white-bg country-icon">
                <select class="form-select" name="country_id" id="country_id">
                    <option selected>Country</option>
                    @foreach($countries as $key => $value)
                    <option value="{{ $value->id }}" data-phone="{{$value->phone_code}}"
                            {{ old('country_id') == $value->id ? "selected" : "" }}>
                        {{ $value->name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <input type="number" class="form-control phone-icon" placeholder="Phone" name="phone" value="{{ old('phone') }}" minlength="8"
                   maxlength="15" autocomplete="phone" required>
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="number" class="form-control postal-code-icon" placeholder="Postal Code" name="postal_code" value="{{ old('postal_code') }}"
                   autocomplete="postal_code">
            @error('postal_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="url" class="form-control url-icon" placeholder="Website" name="website" value="{{ old('website') }}"
                   autocomplete="website">
            @error('website')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="white-bg global-icon">
                <select class="form-select" name="language" required>
                    <option selected>Language</option>
                    @foreach($language as $key => $value)
                    <option value="{{ $key }}"
                            {{ old('language') == $key ? "selected" : "" }}>{{ $value }}
                    </option>
                    @endforeach
                </select>
                @error('language')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control paypal-icon" placeholder="Paypal" name="paypal"
                   autocomplete="paypal">
            @error('paypal')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="password" class="form-control password-icon" placeholder="Password" id="password" name="password" autocomplete="new-password"
                   required>
        </div>
        <div class="col-md-6">
            <input type="password" class="form-control password-icon" placeholder="Confirm Password" name="password_confirmation"
                   autocomplete="new-password" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" value="{{ old('local_beach_break')}}"
                   name="local_beach_break" data-beachID=""
                   placeholder="Local Beach"
                   class="form-control location-icon  @error('local_beach_break') is-invalid @enderror search-box">

            <input type="hidden" name="local_beach_break_id"
                   id="local_beach_break_id" class="form-control">

            <div class="auto-search search1" id="country_list"></div>
            @error('local_beach_break')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="white-bg camera-icon">
                <select class="form-select" name="camera_brand">
                    <option selected>Preferred Camera Brand</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                @error('camera_brand')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-check mb-4">
        <input name="terms" class="form-check-input" type="radio"  id="flexRadioDefault1" required>
        <label class="form-check-label" for="flexRadioDefault1">
            Accept <a href="javaScript:void(0)" class="blue-txt" data-toggle="modal" data-target="#exampleModal">Legal Terms & Conditions</a>
        </label>
        @error('terms')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="user_type_id" id="user_type_id">
            <input type="submit" class="btn blue-btn w-100" value="SIGNUP">
        </div>
    </div>
    <div class="sign-in-anchor">Already have an account? <a href="/login" class="blue-txt">Sign In</a></div>
</form>

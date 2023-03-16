
<form method="POST" id="register" name="register-advertiser" action="{{ route('register') }}"
      enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="upload-photo">
                <div>
                    <img src="" id="category-img-tag" alt="">
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
            <input type="text" class="form-control company-icon" placeholder="Company Name" name="company_name" value="" minlength="3"
                   autocomplete="company_name" required>
            @error('company_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
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
            <input type="email" class="form-control email-icon" placeholder="Email" name="email"
                   value="{{ old('email') }}" autocomplete="email" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <!-- <div class="company-icon white-bg">
                <select class="form-select" name="industry" required>
                    <option selected>Industry</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                @error('industry')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div> -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="password" class="form-control password-icon" placeholder="Password" id="password3" name="password" autocomplete="new-password"
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
        <div class="col-md-12">
            <input type="text" class="form-control location-icon" placeholder="Compay Address" name="company_address" value="" minlength="3"
                   autocomplete="company_address" required>
            @error('company_address')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control location-icon" placeholder="Suburb" name="suburb" value="" minlength="3"
                   autocomplete="suburb" >
            @error('suburb')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="location-icon white-bg">
                <select class="form-select" name="state_id" id="state_id">
                    <option selected>State</option>
                    @foreach($states as $key => $value)
                    <option value="{{ $value->id }}"
                            {{ old('state_id') == $value->id ? "selected" : "" }}>
                        {{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
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
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control paypal-icon" placeholder="Paypal" name="paypal"
                   autocomplete="paypal" require>
            <span class="align-middle d-inline-block ms-3">Compulsory to link PayPal account for billing.</span>
            @error('paypal')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="form-check mb-4">
        <input name="terms" class="form-check-input" type="radio"  id="flexRadioDefault3" required>
        <label class="form-check-label" for="flexRadioDefault3">
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

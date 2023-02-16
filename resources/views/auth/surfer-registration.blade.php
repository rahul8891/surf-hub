
<form method="POST" id="register" name="register-surfer" action="{{ route('register') }}"
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
    <div class="row mt-4">
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="User Name" name="user_name" value="{{ old('user_name') }}" minlength="5"
                   maxlength="25" required autocomplete="user_name">
            @error('user_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="white-bg user-type-icon">
                <select class="form-select">
                    <option selected>Select User Type</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="First Name" name="first_name"
                   value="{{ old('first_name') }}" minlength="3" autocomplete="first_name" required>
            @error('first_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control user-icon" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" minlength="3"
                   autocomplete="last_name" required>
            @error('last_name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="white-bg gender-icon">
                <select class="form-select" name="gender" id="gender" required>
                    <option selected>Gender</option>
                    @foreach($gender_type as $key => $value)
                    <option value="{{ $key }}"
                            {{ old('gender') == $value ? "selected" : "" }}>
                        {{ $value }}</option>
                    @endforeach
                </select>
                @error('gender')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" placeholder="DOB" onfocus="(this.type='date')" class="form-control calender-icon" name="dob" value="{{ old('dob') }}" minlength="3"
                   autocomplete="dob" required>
            @error('dob')
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
            <input type="number" class="form-control postal-code-icon" placeholder="Postal Code" name="postal_code" value="{{ old('postal_code') }}"
                   autocomplete="postal_code">
            @error('postal_code')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="number" class="form-control phone-icon" placeholder="Phone" name="phone" value="{{ old('phone') }}" minlength="8"
                   maxlength="15" autocomplete="phone" required>
            @error('phone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="white-bg user-icon">
                <select class="form-select" name="account_type" required>
                    <option selected>Account Type</option>
                    @foreach($accountType as $key => $value)
                    <option value="{{ $key }}"
                            {{ old('account_type') == $key ? "selected" : "" }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
                @error('language')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input type="text" value="{{ old('local_beach_break')}}"
                   name="local_beach_break" data-beachID=""
                   placeholder="Local Beach"
                   class="form-control location-icon  @error('local_beach_break') is-invalid @enderror search-box3">

            <input type="hidden" name="local_beach_break_id"
                   id="local_beach_break_id_surfer" class="form-control">

            <div class="auto-search search3" id="country_list3"></div>
            @error('local_beach_break')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="white-bg board-icon">
                <select class="form-select" name="board_type">
                    <option selected>Preferred Board</option>
                    @foreach($board_type as $key => $value)
                    <option value="{{ $key }}"
                            {{ old('board_type') == $key ? "selected" : "" }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
                @error('board_type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
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
            <input type="password" class="form-control password-icon" placeholder="Password" id="password2" name="password" autocomplete="new-password"
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
    <div class="form-check mb-4">
        <input name="terms" class="form-check-input" type="radio"  id="flexRadioDefault4" required>
        <label class="form-check-label" for="flexRadioDefault4">
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

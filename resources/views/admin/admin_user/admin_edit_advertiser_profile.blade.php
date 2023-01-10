@extends('layouts.admin.admin_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.admin.admin_left_sidebar')
            </div>
            <div class="middle-content" id="post-data">

                <div class="container mt-5">
                    <h2 class="text-center mb-4">Edit Profile</h2>
                    <form method="POST" id="storeProfile" name="edit-advertiser" action="{{ route('adminUserUpdate',Crypt::encrypt($user->id)) }}"
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
                    <!--            <span id="imageError" class="notDisplayed d-done required">{{ __('Please upload files having
                                                                extensions: jpg, jpeg, png') }}</span>-->
                                @error('profile_photo_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="Company Name" name="company_name"
                                       value="{{ $user->user_profiles->company_name }}" minlength="3" autocomplete="company_name">
                                @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control phone-icon" placeholder="Phone" name="phone" value="{{ $user->user_profiles->phone }}" minlength="8"
                                       maxlength="15" autocomplete="phone" required>
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="Contact First Name" name="first_name"
                                       value="{{ $user->user_profiles->first_name }}" minlength="3" autocomplete="first_name" required>
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="Contact Last Name" name="last_name" value="{{ $user->user_profiles->last_name }}" minlength="3"
                                       autocomplete="last_name" required>
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
            <div class="company-icon white-bg">
                <select class="form-select" name="industry" required>
                    <option value="">Industry</option>
                    <option value="1" {{ $user->user_profiles->industry == 1 ? "selected" : "" }}>One</option>
                    <option value="2" {{ $user->user_profiles->industry == 2 ? "selected" : "" }}>Two</option>
                    <option value="3" {{ $user->user_profiles->industry == 3 ? "selected" : "" }}>Three</option>
                </select>
                @error('industry')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-12">
            <input type="text" class="form-control location-icon" placeholder="Compay Address" name="company_address" value="{{ $user->user_profiles->company_address }}" minlength="3"
                   autocomplete="company_address" required>
            @error('company_address')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
                        </div>
                         <div class="row">
        <div class="col-md-6">
            <input type="text" class="form-control location-icon" placeholder="Suburb" name="suburb" value="{{ $user->user_profiles->suburb }}" minlength="3"
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
                            {{ $user->user_profiles->state_id == $value->id ? "selected" : "" }}>
                        {{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control postal-code-icon" placeholder="Postal Code" name="postal_code" value="{{ $user->user_profiles->postal_code }}"
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
                                                {{ $user->user_profiles->country_id == $value->id ? "selected" : "" }}>
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
                                       autocomplete="paypal" value="{{ $user->user_profiles->paypal }}">
                                @error('paypal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-4">
                                <input type="hidden" name="user_type_id" id="user_type_id">
                                <input type="submit" class="btn blue-btn w-100" value="UPDATE">
                            </div>
                        </div>

                    </form>


                </div>
            </div>

            <div class="right-advertisement">
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
@include('elements/location_popup_model')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">


$('.pos-rel a').each(function () {
    $(this).on('hover, mouseover, click', function () {
        $(this).children('.userinfoModal').find('input[type="text"]').focus();
    });
});
</script>
@endsection
@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
            <div class="middle-content" id="post-data">

                <div class="container mt-5">
                    <h2 class="text-center mb-4">Edit Profile</h2>
                    <form method="POST" id="edit-surfer" name="edit-surfer" action="{{ route('storeProfile') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="upload-photo">
                                    <div>
                                        @if(file_exists(storage_path('app/public/'.$user->profile_photo_path)))
                                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" id="category-img-tag" alt="">
                                        @else
                                            <img src="" id="category-img-tag" alt="">
                                        @endif
                                        <input type="file" accept=".png, .jpg, .jpeg" id="exampleInputFile" name="profile_photo_name">
                                        <input type="hidden" accept=".png, .jpg, .jpeg" id="imagebase64" name="profile_photo_blob" />
                                    </div>
                                    <span class="align-middle d-inline-block ms-3">Upload Profile Pic</span>
                                </div>
                                @error('profile_photo_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="User Name" name="user_name" value="{{ $user->user_name }}" minlength="5"
                                       maxlength="25" required autocomplete="user_name">
                                @error('user_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="white-bg user-type-icon">
                                    <select class="form-select" name="user_type" disabled>
                                        <option value="">Select User Type</option>
                                        <option value="USER" selected>Surfer</option>
                                        <option value="PHOTOGRAPHER">Photographer</option>
                                        <option value="SURFER CAMP">Surf Camp</option>
                                        <option value="ADVERTISEMENT">Advertiser</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="First Name" name="first_name"
                                       value="{{ $user->user_profiles->first_name }}" minlength="3" autocomplete="first_name" required>
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="Last Name" name="last_name" value="{{ $user->user_profiles->first_name }}" minlength="3"
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
                                        <option value="">Gender</option>
                                        @foreach($gender_type as $key => $value)
                                        <option value="{{ $key }}" {{ ($user->user_profiles->gender == $key) ? "selected" : "" }} >
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
                                <input type="date" class="form-control calender-icon" name="dob" value="{{ $user->user_profiles->dob }}" minlength="3"
                                       autocomplete="dob" required>
                                @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control paypal-icon" placeholder="Paypal" name="paypal"
                                       autocomplete="paypal" value="{{ $user->user_profiles->paypal }}">
                                @error('paypal')
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
                                                {{ $user->user_profiles->country_id == $value->id ? "selected" : "" }}>
                                            {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control postal-code-icon" placeholder="Postal Code" name="postal_code" value="{{ $user->user_profiles->postal_code }}"
                                       autocomplete="postal_code">
                                @error('postal_code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="number" class="form-control phone-icon" placeholder="Phone" name="phone" value="{{ $user->user_profiles->phone }}" minlength="8"
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
                                                {{ $user->account_type == $key ? "selected" : "" }}>
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
                                <input type="text" value="{{ $beach }}"
                                       name="local_beach_break" data-beachID=""
                                       placeholder="Local Beach"
                                       class="form-control location-icon  @error('local_beach_break') is-invalid @enderror search-box3">

                                <input type="hidden" name="local_beach_break_id"
                                       id="local_beach_break_id_surfer" class="form-control" value="{{ $user->user_profiles->local_beach_break_id}}">

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
                                                {{ $user->user_profiles->preferred_board == $key ? "selected" : "" }}>
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
                <img src="/img/new/advertisement1.png" alt="advertisement">
                <img src="/img/new/advertisement2.png" alt="advertisement">
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

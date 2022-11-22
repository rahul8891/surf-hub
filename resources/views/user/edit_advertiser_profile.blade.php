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
                    <form method="POST" id="edit-profile" name="edit-profile" action="{{ route('storeProfile') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control user-icon" placeholder="User Name" name="user_name" value="{{ old('user_name') }}" minlength="5"
                                       maxlength="25" required autocomplete="user_name">
                                @error('user_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-3">
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
@include('elements/location_popup_model')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
var page = 1;

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page) {
    var url = window.location.href;
    if (url.indexOf("?") !== -1) {
        var url = window.location.href + '&page=' + page;
    } else {
        var url = window.location.href + '?page=' + page;
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        beforeSend: function () {
            $('.ajax-load').show();
        }
    })
            .done(function (data) {
                if (data.html == "") {
                    $('.ajax-load').addClass('requests');
                    $('.ajax-load').html("No more records found");
                    return;
                }

                $('.ajax-load').removeClass('requests');
                $('.ajax-load').hide();
//            $("#post-data").insertBefore(data.html);
                $(data.html).insertBefore(".ajax-load");
            });
}

$(document).on('click', '.editBtnVideo', function () {
    var id = $(this).data('id');

    $.ajax({
        url: '/getPostData/' + id,
        type: "get",
        async: false,
        success: function (data) {
            // console.log(data.html);
            $("#edit_image_upload_main").html("");
            $("#edit_image_upload_main").append(data.html);
            $("#edit_image_upload_main").modal('show');
        }
    });
});

$('.pos-rel a').each(function () {
    $(this).on('hover, mouseover, click', function () {
        $(this).children('.userinfoModal').find('input[type="text"]').focus();
    });
});
</script>
@endsection
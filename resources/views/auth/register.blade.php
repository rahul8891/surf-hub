@extends('layouts.user.new_layout')
@section('content')

<div class="register-wrap">
    <div class="container">
        <h1>Registration</h1>
        <form>
            <div class="row">
                <div class="col-md-6">
                    <select class="form-select ps-2" name="user_type" id="user_type" required onchange="getform(this.value)">
                        <option value="">Select User Type</option>
                        <option value="2" selected="">Surfer</option>
                        <option value="5">Photographer</option>
                        <option value="6">Surf Camp</option>
                        <option value="3">Advertiser</option>
                    </select>
                    @error('language')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-check mb-4 no-user-selected">
                <input name="terms" class="form-check-input" type="radio"  id="flexRadioDefault1" required>
                <label class="form-check-label" for="flexRadioDefault1">
                    Accept <a href="javaScript:void(0)" class="blue-txt" data-toggle="modal" data-target="#exampleModal">Legal Terms & Conditions</a>
                </label>
                @error('terms')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row no-user-selected">
                <div class="col-md-6">
                    <input type="hidden" name="user_type_id" id="user_type_id">
                    <input type="submit" class="btn blue-btn w-100" value="SIGNUP">
                </div>
            <div class="sign-in-anchor">Already have an account? <a href="/login" class="blue-txt">Sign In</a></div>
            </div>
        </form>
        <div class="d-none photographer-fileds">
            @include('auth/photographer-registration')
        </div>
        <div class="d-none resort-fields">
            @include('auth/resort-registration')
        </div>
        <div class="d-none advertise">
            @include('auth/advertiser-registration')
        </div>
        <div class="d-none normal-user-fields">
            @include('auth/surfer-registration')
        </div>
    </div>
</div>

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

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<script type="text/javascript">
    const phoneresort = document.querySelector("#phoneresort");
    window.intlTelInput(phoneresort, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
    const phoneadvertiser = document.querySelector("#phoneadvertiser");
    window.intlTelInput(phoneadvertiser, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
    const phonephoto = document.querySelector("#phonephoto");
    window.intlTelInput(phonephoto, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
    const phonesurfer = document.querySelector("#phonesurfer");
    window.intlTelInput(phonesurfer, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
    });
    
    $(document).ready(function () {
        getform(2);

        jQuery('#phonesurfer').on('change', function() {
            var country_code = jQuery(this).siblings('.iti__flag-container').children('.iti__selected-flag').attr('title');
            jQuery('.country_code').val(country_code);
        });
        jQuery('.iti__country-list li').on('click', function() {
            var country_code = jQuery(this).children('.iti__dial-code').html();
            jQuery('.country_code').val(country_code);
        });


    });
    function getform(val) {
        $("form[name='register-surfer'] #user_type_id").val(val);
        $("form[name='register-resort'] #user_type_id").val(val);
        $("form[name='register-advertiser'] #user_type_id").val(val);
        $("form[name='register'] #user_type_id").val(val);
        if (val == 5) {
            $('.photographer-fileds').removeClass('d-none');
            $('.normal-user-fields').addClass('d-none');
            $('.resort-fields').addClass('d-none');
            $('.advertise').addClass('d-none');
            $('.no-user-selected').addClass('d-none');
            $('#common-fields').removeClass('d-none');
            $('.hide-for-advertise').removeClass('d-none');

            return true;
        }
        if (val == 6) {
            $('.photographer-fileds').addClass('d-none');
            $('.normal-user-fields').addClass('d-none');
            $('.advertise').addClass('d-none');
            $('.resort-fields').removeClass('d-none');
            $('#common-fields').removeClass('d-none');
            $('.hide-for-advertise').removeClass('d-none');
            $('.no-user-selected').addClass('d-none');
            return true;
        }
        if (val == 2) {
            $('.photographer-fileds').addClass('d-none');
            $('.resort-fields').addClass('d-none');
            $('.advertise').addClass('d-none');
            $('.normal-user-fields').removeClass('d-none');
            $('#common-fields').removeClass('d-none');
            $('.hide-for-advertise').removeClass('d-none');
            $('.no-user-selected').addClass('d-none');
            return true;
        }
        if (val == 3) {
            $('.photographer-fileds').addClass('d-none');
            $('.resort-fields').addClass('d-none');
            $('.normal-user-fields').addClass('d-none');
            $('#common-fields').removeClass('d-none');
            $('.advertise').removeClass('d-none');
            $('.hide-for-advertise').addClass('d-none');
            $('.no-user-selected').addClass('d-none');
            return true;
        } else {
            $('.photographer-fileds').addClass('d-none');
            $('.resort-fields').addClass('d-none');
            $('.normal-user-fields').addClass('d-none');
            $('#common-fields').addClass('d-none');
            $('.advertise').addClass('d-none');
            $('.hide-for-advertise').addClass('d-none');
            $('.no-user-selected').removeClass('d-none');
            return true;
        }
    }
</script>
@endsection

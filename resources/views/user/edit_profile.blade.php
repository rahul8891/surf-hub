@extends('layouts.user.new_layout')
@section('content')
@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
            <div class="middle-content" id="post-data">
                @include('layouts.user.content_menu')

                <div class="container">
                    <h1>Registration</h1>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select ps-2" name="user_type" id="user_type" required onchange="getform(this.value)">
                                    <option value="">Select User Type</option>
                                    <option value="2" selected="">Surfer</option>
                                    <option value="3">Advertisement</option>
                                    <option value="5">Photographer</option>
                                    <option value="6">Surfer Camp</option>
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

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;
        if(url.indexOf("?") !== -1) {
            var url = window.location.href + '&page=' + page;
        }else {
            var url = window.location.href + '?page=' + page;
        }
        
        $.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function() {
                $('.ajax-load').show();
            }
        })
        .done(function(data) {
            if(data.html == "") {
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
        
        $(document).on('click', '.editBtnVideo', function() {
            var id = $(this).data('id');
            
            $.ajax({
                url: '/getPostData/' + id,
                type: "get", 
                async: false,
                success: function(data) {
                    // console.log(data.html);
                    $("#edit_image_upload_main").html("");
                    $("#edit_image_upload_main").append(data.html);
                    $("#edit_image_upload_main").modal('show');                
                }
            });
        });
        
        $('.pos-rel a').each(function(){
           $(this).on('hover, mouseover, click', function() {
                $(this).children('.userinfoModal').find('input[type="text"]').focus();
            });
        });
</script>
@endsection
@endsection
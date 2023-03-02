<div class="container">
	<div class="row align-items-lg-center">
		<div class="col-lg-4">
			<p class="text-center text-lg-start"> Copyright 2020, All rights reserved.</p>
		</div>
		<div class="col-lg-8">
			<div class="justify-content-center justify-content-lg-end navbar-nav flex-wrap">
				@if (Auth::user())
                                <a class="nav-link" href="{{ route('followRequests') }}">Follow Requests</a>
				<a class="nav-link" href="{{ route('profile') }}">My Profile</a>
				@endif
                                <a class="nav-link" href="{{ route('privacy') }}">Privacy Policy</a>
				<a class="nav-link" href="{{ route('terms') }}">T&C's</a>
				<a class="nav-link" href="{{ route('faq') }}">Help/FAQ's</a>
				<a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
			</div>
		</div>
	</div>
</div>
<a onclick="topFunction()" id="scrollToTop" title="Scroll to Top" style="display: none;">Top<span></span></a>
<style>
#scrollToTop {position:fixed;right:20px;bottom:28px;cursor:pointer;width:40px;height:40px;background-color:#000000;text-indent:-9999px;display:none;-webkit-border-radius:60px;-moz-border-radius:60px;border-radius:60px}
#scrollToTop span {position:absolute;top:50%;left:50%;margin-left:-8px;margin-top:-12px;height:0;width:0;border:8px solid transparent;border-bottom-color:#ffffff}
#scrollToTop:hover {background-color:#007bff;opacity:1;filter:"alpha(opacity=100)";-ms-filter:"alpha(opacity=100)";}
</style>

<script src="{{ asset('js/new/jquery-3.5.1.min.js') }}"></script>

<script src="{{ asset('js/new/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/js/new/bootstrap.js') }}"></script>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<script src="{{ asset('js/new/croppie.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5JiYXogWVNPfX_L4uA0oWb-qiNSfKfYk"></script>
<script src="https://vjs.zencdn.net/5.19.2/video.js"></script>
<script src="{{ asset('/js/hls/hls.min.js?v=v0.9.1') }}"></script>
<script src="{{ asset('/js/hls/videojs5-hlsjs-source-handler.min.js?v=0.3.1') }}"></script>
<script src="{{ asset('/js/hls/vjs-quality-picker.js?v=v0.0.2') }}"></script>

<script src="{{ asset('js/new/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/new/star-rating.min.js')}}"></script>    
<script src="{{ asset('js/new/slick.js')}}"></script>

<script src="{{ asset('js/new/custom.js') }}"></script>
<script src="{{ asset('js/new/post.js')}}"></script>
<script src="{{ asset('js/new/script.js') }}"></script>
<script src="http://jwpsrv.com/library/4+R8PsscEeO69iIACooLPQ.js"></script>

<script type="text/javascript" async>
	jQuery.noConflict();
	jQuery(document).ready(function () {
	  jQuery.ajax({
	      type: "GET",
	      url: "/follow-counts",
	      dataType: "json",
	      success: function (jsonResponse) {
	          jQuery('#follwers').html(jsonResponse['follwers']);
	          jQuery('#follwing').html(jsonResponse['follwing']);
	          jQuery('#followRequest').html(jsonResponse['follwerRequest']);
	          jQuery('#posts').html(jsonResponse['posts']);
	          jQuery('#uploads').html(jsonResponse['uploads']);
	          jQuery('#surferRequest').html(jsonResponse['surferRequest']);
	          jQuery('#notification-count').html(jsonResponse['notification']);
	      }
	  });
	});

	jQuery('.rating-filter').rating({
		showClear: false,
		showCaption: false
	});

    jQuery(function(){
        jQuery('#filter_user_type').multiSelect();
    });

    function ratingShow(e) {
        jQuery(e).children(".rating-container").show();
        jQuery(e).children(".avg-rating").hide();
    }
    jQuery(document).on('click', '.rating-container', function (e) {
        jQuery(e).children(".rating-container").hide();
        jQuery(e).children(".avg-rating").hide();
    });

    jQuery('.rating').rating({
        showClear: false,
        showCaption: false
    });
    jQuery('.rating-filter').rating({
        showClear: false,
        showCaption: false
    });
    jQuery(document).ready(function () {
        jQuery("#My-Profile").click(function () {
            jQuery(".profileChangePswd").toggleClass("show");
        });
    });

    window.HELP_IMPROVE_VIDEOJS = false;
                
    jQuery( ".jw-video-player" ).each(function( i ) {
        var videoID = $(this).attr('data-id');
        var video = $(this).attr('data-src');
        // console.log("Data = myVideoTag"+videoID+"  --  "+video);
        var options = {};

        videojs('myVideoTag'+videoID).ready(function () {
            var myPlayer = this;
            myPlayer.qualityPickerPlugin();
            myPlayer.src({
                type: 'application/x-mpegURL', 
                src: video
            });
        });
    });
    //
    function openFullscreen(id) {
        var elem = document.getElementById("myImage" + id);
        if (elem.requestFullScreen) {
            elem.requestFullScreen();
            elem.webkitEnterFullscreen();
            elem.enterFullscreen();
        } else if (elem.webkitRequestFullScreen) { /* Safari */
            elem.webkitRequestFullScreen();
            elem.webkitEnterFullscreen();
            elem.enterFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
            elem.enterFullscreen();
        } else if (elem.msRequestFullScreen) { /* IE11 */
            elem.msRequestFullScreen();
            elem.enterFullscreen();
        }
    }



    // var page = 1;

    // jQuery(window).scroll(function() { alert('aa');
    //     if(jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()) { alert('ccc');
    //         page++;
    //         loadMoreData(page);
    //     } else {
    //         alert('dd');
    //     }
    // });

    // function loadMoreData(page) { alert('aaa');
    //     var url = window.location.href;
    //     if(url.indexOf("?") !== -1) {
    //         var url = window.location.href + '&page=' + page;
    //     }else {
    //         var url = window.location.href + '?page=' + page;
    //     }
        
    //     jQuery.ajax({
    //         url: url,
    //         type: "get",
    //         async: false,
    //         beforeSend: function() {
    //             jQuery('.ajax-load').show();
    //         }
    //     })
    //     .done(function(data) {
    //         if(data.html == "") {
    //             jQuery('.ajax-load').addClass('requests');
    //             jQuery('.ajax-load').html("No more records found");
    //             return;
    //         }

    //         jQuery('.ajax-load').removeClass('requests');
    //         jQuery('.ajax-load').hide();
    //         jQuery(data.html).insertBefore(".ajax-load");
    //     });
    // }
        
    jQuery('.right-options').on('click', '.editBtnVideo', function() {
        var id = jQuery(this).data('id');
        
        jQuery.ajax({
            url: '/getPostData/' + id,
            type: "get", 
            async: false,
            success: function(data) {
                jQuery("#edit_image_upload_main").html("");
                jQuery("#edit_image_upload_main").append(data.html);
                jQuery("#edit_image_upload_main").modal('show');                
            }
        });
    });
    
    jQuery('.pos-rel a').each(function(){
       jQuery(this).on('hover, mouseover, click', function() {
            jQuery(this).children('.userinfoModal').find('input[type="text"]').focus();
        });
    });
    
    function openFullscreenSilder(id) {
        jQuery.ajax({
            url: '/getPostFullScreen/' + id,
            type: "get", 
            async: false,
            success: function(data) {
                jQuery("#full_screen_modal").html("");
                jQuery("#full_screen_modal").append(data.html);
                jQuery("#full_screen_modal").modal('show');                
            }
        });
    }

	jQuery(document).on('click', '.highlightPost', function (e) {
		var that = $(this);
		var postID = $(this).data('id');

		jQuery.ajax({
		    url: '/highlight-post/' + postID,
		    type: "get", 
		    async: false,
		    success: function(result) {
		        if(result.data.is_highlight == "1") {
		            that.addClass('blue');
		        } else {
		            that.removeClass('blue');
		        }
		    }
		});
	});
        

    mybutton = document.getElementById("scrollToTop");
    window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}

	function topFunction() {
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	} 
</script>
<script src="{{ asset('js/new/jquery.multi-select.js') }}"></script>
@include('elements/location_popup_model')
@include('layouts/models/edit_image_upload')
@include('layouts/models/full_screen_modal')
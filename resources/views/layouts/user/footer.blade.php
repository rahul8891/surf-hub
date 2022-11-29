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
<script type='text/javascript' async >
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
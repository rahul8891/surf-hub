<div class="container-fluid">
    <div class="d-flex">
        <div class="copyright">
            &copy; Copyright 2020, All rights reserved.
        </div>
        <div class="btmNav">
            <ul class="pl-0 mb-0 d-flex align-items-center">
                @auth
                <li>
                    <a href="#">Follow Requests
                        <span class="followCount">14</span>
                    </a>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="javascript:void(0)" id="My-Profile">My Profile
                    </a>
                    <div class="profileChangePswd">
                        <ul>
                            <li><a href="{{ route('profile') }}">Profile</a></li>
                            <li><a href="{{ route('showPassword') }}">Change Password</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                @endif
                <li>
                    <a href="{{ route('privacy') }}">Privacy Policy</a>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="{{ route('terms') }}"> T&C's</a>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="{{ route('faq') }}">Help/FAQ's</a>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="{{ route('contact') }}">Contact Us</a>
                </li>
                @auth
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#{{ route('logout') }}"
                            onclick="event.preventDefault();this.closest('form').submit();">Sign Out</a>
                    </form>
                </li>
                @endif
            </ul>
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
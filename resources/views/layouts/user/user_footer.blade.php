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
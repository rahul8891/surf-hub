<div class="container-fluid">
    <div class="d-flex">
        <div class="copyright">
            &copy; Copyright 2020, All rights reserved.
        </div>
        <div class="btmNav">
            <ul class="pl-0 mb-0 d-flex align-items-center">
                @auth
                <li>
                    <a href="{{ route('followRequests') }}">Follow Requests
                        @if(getNotificationCount() > 0)
                            <span class="followCount">{{ getNotificationCount() }}</span>
                        @endif
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
                    <a href="{{ route('terms') }}"> T&Cs</a>
                </li>
                <li>
                    <span class="divider"></span>
                </li>
                <li>
                    <a href="{{ route('faq') }}">Help/FAQs</a>
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
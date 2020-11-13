@if(Auth::user())
<div class="feedHubNav">
    <div class="container">
        <ul class="mb-0 pl-0">
            <li class="{{ userActiveMenu('dashboard') }}">
                <a href="{{ url('dashboard')}}">Feed</a>
            </li>
            <li class="{{ userActiveMenu('myhub') }}">
                <a href="{{ route('myhub') }}">My Hub</a>
            </li>
            <li>
                <a href="#">Search</a>
            </li>
        </ul>
    </div>
</div>
@endif
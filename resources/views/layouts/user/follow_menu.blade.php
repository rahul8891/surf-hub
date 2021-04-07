@if(Auth::user())
<div class="feedHubNav followRequestLinksWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <ul class="mb-0 pl-0">
                    <li class="{{ userActiveMenu('followRequests') }}">
                        <a href="{{ route('followRequests') }}">Follow Requests</a>
                    </li>
                    <li class="{{ userActiveMenu('followers') }}">
                        <a href="{{ route('followers') }}">Followers</a>
                    </li>
                    <li class="{{ userActiveMenu('following') }}">
                        <a href="{{ route('following') }}">Following</a>
                    </li>
                    <li class="backBtn">
                        <a href="/"><img src="img/backBtnIcon.png" alt="" class="pr-2">Back</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endif
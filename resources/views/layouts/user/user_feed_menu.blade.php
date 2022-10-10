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
            <li class="{{ userActiveMenu('searchPosts') }}">
                <a href="{{ url('search')}}">Search</a>
            </li>
            <li class="{{ userActiveMenu('searchPosts') }}">
                <a href="{{ url('surferRequestList')}}">Recieved Request</a>
            </li>
        </ul> 
        <!-- <ul class="mb-0 pl-0">
            <li class="{{ userActiveMenu('dashboard') }}">
                <a href="{{ url('dashboard')}}" data-toggle="tooltip" data-placement="bottom" title="Feed"><img src="/img/feed-button.png"></a>
            </li>
            <li class="{{ userActiveMenu('myhub') }}">
                <a href="{{ route('myhub') }}" data-toggle="tooltip" data-placement="bottom" title="My Hub"><img src="/img/myhub.jpg"></a>
            </li>
            <li class="{{ userActiveMenu('searchPosts') }}">
                <a href="{{ url('search')}}" data-toggle="tooltip" data-placement="bottom" title="Search"><img src="/img/search.png"></a>
            </li>
            <li class="">
                <a href="#" data-toggle="modal" data-target="#exampleModal" data-backdrop="static" data-keyboard="false" data-placement="bottom" title="Upload"><img src="/img/uploadImage.png"></a>
            </li>
        </ul> -->  
    </div>
</div>
@endif
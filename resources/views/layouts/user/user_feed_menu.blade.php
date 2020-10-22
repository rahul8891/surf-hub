@if(Auth::user())
<div class="feedHubNav">
    <div class="container">
        <ul class="mb-0 pl-0">
            <li class="active">
                <a href="#">Feed</a>
            </li>
            <li>
                <a href="#">My Hub</a>
            </li>
            <li>
                <a href="#">Search</a>
            </li>
        </ul>
    </div>
</div>
@endif
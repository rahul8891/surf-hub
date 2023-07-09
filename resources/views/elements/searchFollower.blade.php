@if (count($followers) > 0)
    @foreach ($followers as $key => $follower)
    <div class="row-listFollowers">
        <div class="row align-items-center gap-2 gap-md-0">
            <div class="col-md-6 follwer-name">
                @if($follower->follower->profile_photo_path)
                <img src="{{ asset('storage/'.$follower->follower->profile_photo_path) }}" alt=""
                     class="align-middle bg-white">
                @else
                <span class="">
                    {{ucwords(substr($follower->follower->user_profiles->first_name,0,1))}}{{ucwords(substr($follower->follower->user_profiles->last_name,0,1))}}
                </span>
                @endif
                <span class="align-middle">{{ucfirst($follower->follower->user_profiles->first_name)}} {{ucfirst($follower->follower->user_profiles->last_name)}}</span>
            </div>
            <div class="col-md-6 text-md-end">
                @if($follower->follower_request_status == 1)
                <button class="btn grey-borderBtn me-3 remove" data-id="{{$follower->id}}">
                    <img src="/img/delete-bold.png" class="me-1 align-middle" alt="Remove">
                    <span class="align-middle">REMOVE</span>
                </button>
                <button class="btn grey-borderBtn accept-follow" data-id="{{$follower->id}}" data-post_id="{{$follower->id}}">
                    <img src="/img/follow-user.png" class="me-1 align-middle" alt="Follow">
                    <span class="align-middle">FOLLOW</span>
                </button>
                @else
                <button class="btn grey-borderBtn me-3 unfollow" data-id="{{$follower->id}}">
                    <img src="/img/follow-user.png" class="me-1 align-middle" alt="Unfollow">
                    <span class="align-middle">UNFOLLOW</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@else
<div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
</div>
@endif
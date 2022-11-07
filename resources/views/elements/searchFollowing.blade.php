@if (count($following) > 0)
                        @foreach ($following as $key => $followings)
                        <div class="row-listFollowers">
                            <div class="row align-items-center gap-2 gap-md-0">
                                <div class="col-md-6 follwer-name">
                                    @if($followings->follower->profile_photo_path)
                                    <img src="{{ asset('storage/'.$followings->followed->profile_photo_path) }}" alt=""
                                         class="align-middle bg-white">
                                    @else
                                    <span class="">
                                        {{ucwords(substr($followings->followed->user_profiles->first_name,0,1))}}{{ucwords(substr($followings->followed->user_profiles->last_name,0,1))}}
                                    </span>
                                    @endif
                                    <span class="align-middle">{{ucfirst($followings->followed->user_profiles->first_name)}} {{ucfirst($followings->followed->user_profiles->last_name)}}</span>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button class="btn grey-borderBtn me-3 unfollow" data-id="{{$followings->id}}">
                                        <img src="/img/follow-user.png" class="me-1 align-middle" alt="Unfollow">
                                        <span class="align-middle">UNFOLLOW</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                         @endforeach
                         @else
                    <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
                    </div>
                @endif
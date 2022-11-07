 @if (count($followRequests) > 0)
                        @foreach ($followRequests as $key => $requests)
                        <div class="row-listFollowers">
                            <div class="row align-items-center gap-2 gap-md-0">
                                <div class="col-md-6 follwer-name">
                                    @if($requests->follower->profile_photo_path)
                                    <img src="{{ asset('storage/'.$requests->follower->profile_photo_path) }}" alt=""
                                         class="align-middle bg-white">
                                    @else
                                    <img src="/img/follower-img.png" alt=""
                                         class="align-middle bg-white notification-img">
                                    @endif
                                    <span class="align-middle">{{ucfirst($requests->follower->user_profiles->first_name)}} {{ucfirst($requests->follower->user_profiles->last_name)}}</span>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button class="btn grey-borderBtn me-3 accept" data-id="{{$requests->id}}">
                                        <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                        <span class="align-middle">ACCEPT</span>
                                    </button>
                                    <button class="btn grey-borderBtn reject" data-id="{{$requests->id}}">
                                        <img src="img/reject.png" class="me-1 align-middle" alt="REJECT">
                                        <span class="align-middle">REJECT</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
                    </div>
                @endif
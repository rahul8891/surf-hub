@if(isset($postsList[0]->id) && !empty($postsList[0]->id))
    @foreach ($postsList as $key => $posts)
                    @if($posts->parent_id == 0)
                <div class="news-feed">

                    <div class="inner-news-feed">
                        <div class="user-details">
                            <div class="user-left">
                                @if(file_exists(asset('storage/'.$posts->user->profile_photo_path)))
                                <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <img src="/img/logo_small.png" class="profileImg" alt="">
                                @endif
                                <div>                                                            
                                    <p class="name"><span>{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span> </p>
                                    <p class="address">{{ $posts->beach_breaks->beach_name ?? '' }} {{ $posts->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                    <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p> 
                                </div>
                            </div>
                            @if($posts->user_id != Auth::user()->id)
                            <div class="user-right"> 
                                <img src="/img/new/normal-user.png" alt="normal-user">

                                <button class="follow-btn follow <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id)) ? ((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                    <img src="/img/new/follow-user.png"> FOLLOW
                                </button>


                            </div>
                            @endif
                        </div>
                        @if(!empty($posts->upload->image))
                        <div class="newsFeedImgVideo">
                            <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                        </div>
                        @elseif(!empty($posts->upload->video))
                        @if (!File::exists($posts->upload->video))
                        <div class="newsFeedImgVideo">
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        </div>    
                        @else
                        <div class="newsFeedImgVideo">
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        </div>
                        @endif
                        @endif
                        <div class="user-bottom-options">
                            <div class="rating-flex">
                                <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">                            
                                <span class="avg-rating">{{ round(floatval($posts->averageRating)) }} (<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span>)</span>

                            </div>
                            <div class="right-options">
                                @if(Auth::user()->id != $posts->user_id)
                                <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}"><img src="/img/new/save.png" alt="Save"></a>
                                @endif
                                @if($posts['surfer'] == 'Unknown' && Auth::user()->id != $posts['user_id'])
                                <a href="{{route('surferRequest', Crypt::encrypt($posts->id))}}"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                @endif
                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                    <img src={{asset("img/location.png")}} alt="Location"></a>
                                <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("img/expand.png")}} alt="Expand"></a>
                                <div class="d-inline-block info dropdown" title="Info">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/warning.png" alt="Info">
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-5">Date</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{date('d-m-Y',strtotime($posts->surf_start_date))}}</div>
                                            <div class="col-5">Surfer</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->surfer}}</div>
                                            <div class="col-5">Posted By</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{ucfirst($posts->user->user_name)}}</div>
                                            <div class="col-5">Beach/Break</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->beach_breaks->beach_name}}/{{$posts->beach_breaks->break_name}}</div>
                                            <div class="col-5">Country</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->countries->name}}</div>
                                            <div class="col-5">State</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->states->name??""}}</div>
                                            <div class="col-5">Wave Size</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">@foreach($customArray['wave_size'] as $key => $value)
                                                @if($key == $posts->wave_size)
                                                {{$value}}
                                                @endif
                                                @endforeach</div>
                                            <div class="col-5">Board Type</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->board_type}}</div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user() && $posts->user_id == Auth::user()->id)
                                <a href="{{route('deleteUserPost', Crypt::encrypt($posts->id))}}"  onclick="return confirm('Do you really want to delete this footage?')"><img src="/img/delete.png" alt="Delete"></a>
                                @endif
                                <div class="d-inline-block tag dropdown" title="Tag">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/tag.png" alt="Tag">
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (count($posts->tags) >= 1)
                                        <div class="username-tag">
                                            @foreach ($posts->tags as $tags)
                                            <div class="">
                                                @if($tags->user->profile_photo_path)
                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="profileImg" alt="">
                                                @else
                                                <span class="initial-name">{{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}</span>
                                                @endif
                                                <span>{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>
                                            </div>
                                            @endforeach 
                                        </div>
                                        @endif
                                        <div>
                                            <input type="text" autofocus name="tag_user"
                                                   placeholder="@ Search user" class="form-control ps-2 tag_user" required data-post_id="{{$posts->id}}">
                                            <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                   id="user_id" class="form-control user_id">
                                            <div class="auto-search tagSearch" id="tag_user_list{{$posts->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->id != $posts->user_id)
                                <div class="d-inline-block report dropdown" title="Report">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/flag.png" alt="Report">
                                    </button>

                                    <div class="dropdown-menu">
                                        <form role="form" method="POST" name="report{{$posts->id}}" action="{{ route('report') }}">
                                            @csrf    
                                            <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                            <h6 class="text-center fw-bold">Report Content</h6>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="incorrectInfo{{$posts->id}}" name="incorrect" value="1">
                                                <label class="form-check-label" for="incorrectInfo{{$posts->id}}">Report Info as
                                                    incorrect</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="inappropriate" value="1"
                                                       id="incorrectContent{{$posts->id}}">
                                                <label class="form-check-label" for="incorrectContent{{$posts->id}}">Report
                                                    content as inappropriate</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="tolls" value="1" id="reportTrolls{{$posts->id}}">
                                                <label class="form-check-label" for="reportTrolls{{$posts->id}}">Report
                                                    tolls</label>
                                            </div>
                                            <div>
                                                <textarea class="form-control ps-2" name="comments" id="{{$posts->id}}"
                                                          placeholder="Additional Comments.."
                                                          style="height: 80px"></textarea>
                                            </div>
                                            <button type="submit" id="submitReport{{$posts->id}}" class="btn blue-btn w-100">REPORT</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
                    @endforeach

    <script type="text/javascript">
        $('.rating').rating({
             showClear:false, 
             showCaption:false
         });
    </script>
@endif
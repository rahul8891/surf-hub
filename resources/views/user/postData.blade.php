@extends('layouts.user.new_layout')
@section('content')

<style>
    .imageWrap {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .imageWrap .overlay {
        position: absolute;
        right: 0;
        z-index: 5;
        background-color: lightgrey;
        border-radius: 5px;
    }
</style>

<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>

            <div class="middle-content" id="post-data">
                <div class="news-feed">
                    <div class="inner-news-feed">
                        <div class="user-details">
                            <div class="user-left">
                                @if (isset($postData->parent_id) && ($postData->parent_id > 0))
                                    @if(file_exists(storage_path('app/public/'.$postData->parentPost->profile_photo_path)))
                                        <img src="{{ asset('storage/'.$postData->parentPost->profile_photo_path) }}" class="profileImg" alt="">
                                    @else
                                        <img src="/img/logo_small.png" class="profileImg" alt="">
                                    @endif
                                    <div>
                                        <p class="name"><span>{{ ucfirst($postData->parentPost->user_profiles->first_name) }} {{ ucfirst($postData->parentPost->user_profiles->last_name) }} ( {{ (isset($postData->parentPost->user_name) && !empty($postData->parentPost->user_name))?ucfirst($postData->parentPost->user_name):"SurfHub" }} )</span> </p>
                                        <p class="address">{{ (isset($postData->beach_breaks->beach_name))?$postData->beach_breaks->beach_name:'' }} {{ (isset($postData->breakName->break_name))?$postData->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($postData->surf_start_date)->format('d-m-Y') }}</p>
                                        <p class="time-ago">{{ postedDateTime($postData->created_at) }}</p>
                                    </div>
                                @else
                                    @if(file_exists(storage_path('app/public/'.$postData->user->profile_photo_path)))
                                    <img src="{{ asset('storage/'.$postData->user->profile_photo_path) }}" class="profileImg" alt="">
                                    @else
                                    <img src="/img/logo_small.png" class="profileImg" alt="">
                                    @endif
                                    <div>
                                        <p class="name"><span>{{ ucfirst($postData->user->user_profiles->first_name) }} {{ ucfirst($postData->user->user_profiles->last_name) }} ( {{ (isset($postData->user->user_name) && !empty($postData->user->user_name))?ucfirst($postData->user->user_name):"SurfHub" }} )</span> </p>
                                        <p class="address">{{ (isset($postData->beach_breaks->beach_name))?$postData->beach_breaks->beach_name:'' }} {{ (isset($postData->breakName->break_name))?$postData->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($postData->surf_start_date)->format('d-m-Y') }}</p>
                                        <p class="time-ago">{{ postedDateTime($postData->created_at) }}</p>
                                    </div>
                                @endif
                            </div>
                            @if($postData->user_id != Auth::user()->id)
                            <div class="user-right">
                                <img src="/img/new/normal-user.png" alt="normal-user">

                                <button class="follow-btn follow <?php echo (isset($postData->followPost->id) && !empty($postData->followPost->id)) ? ((($postData->followPost->status == 'FOLLOW') && ($postData->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $postData->user_id }}" data-post_id="{{ $postData->id }}">
                                    <img src="/img/new/follow-user.png"> FOLLOW
                                </button>


                            </div>
                            @endif
                        </div>
                            @if (isset($postData->parent_id) && ($postData->parent_id > 0))
                                @if(!empty($postData->upload->image))
                                    <div class="newsFeedImgVideo">
                                        <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$postData->parent_id.'/'.$postData->upload->image }}" alt="" id="myImage{{$postData->id}}" class="postImg">
                                    </div>
                                @elseif(!empty($postData->upload->video))
                                    <div class="newsFeedImgVideo jw-video-player" id="myVid{{$postData->id}}" data-id="{{$postData->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$postData->parent_id.'/'.getName($postData->upload->video).'/'.getName($postData->upload->video).'.m3u8' }}">
                                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$postData->id}}"></video>
                                    </div>
                                @endif
                            @else
                                @if(!empty($postData->upload->image))
                                    <div class="newsFeedImgVideo">
                                        <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$postData->user->id.'/'.$postData->upload->image }}" alt="" id="myImage{{$postData->id}}" class="postImg">
                                    </div>
                                @elseif(!empty($postData->upload->video))
                                    <div class="newsFeedImgVideo jw-video-player" id="myVid{{$postData->id}}" data-id="{{$postData->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$postData->user->id.'/'.getName($postData->upload->video).'/'.getName($postData->upload->video).'.m3u8' }}">
                                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$postData->id}}"></video>
                                    </div>
                                @endif
                            @endif
                        <div class="user-bottom-options">
                            <div class="rating-flex">
                                <div class="rating-flex-child">
                                    <input id="rating{{$postData->id}}" name="rating" class="rating rating-loading" data-id="{{$postData->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($postData->averageRating) }}">
                                    <span class="avg-rating">{{ round(floatval($postData->averageRating)) }} (<span id="users-rated{{$postData->id}}">{{ $postData->usersRated() }}</span>)</span>
                                </div>
                                <div class="highlight highlightPost {{ (isset($postData->is_highlight) && ($postData->is_highlight == "1"))?'blue':'' }}" data-id="{{ $postData->id }}"  data-id="{{ $postData->is_highlight }}">
                                    <span>Highlights</span>
                                </div>
                            </div>
                            <div class="right-options">
                                @if(Auth::user()->id != $postData->user_id)
                                <a href="{{route('saveToMyHub', Crypt::encrypt($postData->id))}}"><img src="/img/new/save.png" alt="Save"></a>
                                @endif
                                @if($postData->surfer == 'Unknown' && Auth::user()->id != $postData->user_id)
                                <a href="{{route('surferRequest', Crypt::encrypt($postData->id))}}"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                @endif
                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$postData->beach_breaks->latitude ?? ''}}" data-long="{{$postData->beach_breaks->longitude ?? ''}}" data-id="{{$postData->id}}" class="locationMap">
                                    <img src={{asset("/img/location.png")}} alt="Location"></a>
                                <a onclick="openFullscreenSilder({{$postData->id}});"><img src={{asset("/img/expand.png")}} alt="Expand"></a>
                                <div class="d-inline-block info dropdown" title="Info">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/warning.png" alt="Info">
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-5">Date</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{date('d-m-Y',strtotime($postData->surf_start_date))}}</div>
                                            <div class="col-5">Surfer</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$postData->surfer}}</div>
                                            <div class="col-5">Posted By</div>
                                            <div class="col-2 text-center">:</div>
                                            @if (isset($postData->parent_id) && ($postData->parent_id > 0))
                                            <div class="col-5">{{ucfirst($postData->parentPost->user_name)}}</div>
                                            @else
                                                <div class="col-5">{{ucfirst($postData->user->user_name)}}</div>
                                            @endif
                                            <div class="col-5">Beach/Break</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{ (isset($postData->beach_breaks->beach_name))?$postData->beach_breaks->beach_name:'' }}{{ (isset($postData->breakName->break_name))?'/'.$postData->breakName->break_name:'' }}</div>
                                            <div class="col-5">Country</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$postData->countries->name}}</div>
                                            <div class="col-5">State</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$postData->states->name??""}}</div>
                                            <div class="col-5">Wave Size</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">@foreach($customArray['wave_size'] as $key => $value)
                                                @if($key == $postData->wave_size)
                                                {{$value}}
                                                @endif
                                                @endforeach</div>
                                            <div class="col-5">Board Type</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$postData->board_type}}</div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user() && $postData->user_id == Auth::user()->id)
                                <a href="{{route('deleteUserPost', Crypt::encrypt($postData->id))}}"  onclick="return confirm('Do you really want to delete this footage?')"><img src="/img/delete.png" alt="Delete"></a>
                                @endif
                                @if (isset($postData->parent_id) && ($postData->parent_id == 0))
                                    <a href="javascript:void(0)" class="editBtn editBtnVideo" data-id="{{ $postData->id }}"><img src="/img/edit.png" alt="Edit"></a>
                                @endif
                                <div class="d-inline-block tag dropdown" title="Tag">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/tag.png" alt="Tag">
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (count($postData->tags) >= 1)
                                        <div class="username-tag">
                                            @foreach ($postData->tags as $tags)
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
                                                   placeholder="@ Search user" class="form-control ps-2 tag_user" required data-post_id="{{$postData->id}}">
                                            <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                   id="user_id" class="form-control user_id">
                                            <div class="auto-search tagSearch" id="tag_user_list{{$postData->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user()->id != $postData->user_id)
                                <div class="d-inline-block report dropdown" title="Report">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/flag.png" alt="Report">
                                    </button>

                                    <div class="dropdown-menu">
                                        <form role="form" method="POST" name="report{{$postData->id}}" action="{{ route('report') }}">
                                            @csrf
                                            <input type="hidden" class="postID" name="post_id" value="{{$postData->id}}">
                                            <h6 class="text-center fw-bold">Report Content</h6>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="incorrectInfo{{$postData->id}}" name="incorrect" value="1">
                                                <label class="form-check-label" for="incorrectInfo{{$postData->id}}">Report Info as
                                                    incorrect</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="inappropriate" value="1"
                                                       id="incorrectContent{{$postData->id}}">
                                                <label class="form-check-label" for="incorrectContent{{$postData->id}}">Report
                                                    content as inappropriate</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="tolls" value="1" id="reportTrolls{{$postData->id}}">
                                                <label class="form-check-label" for="reportTrolls{{$postData->id}}">Report trolls</label>
                                            </div>
                                            <div>
                                                <textarea class="form-control ps-2" name="comments" id="{{$postData->id}}"
                                                          placeholder="Additional Comments.."
                                                          style="height: 80px"></textarea>
                                            </div>
                                            <button type="submit" id="submitReport{{$postData->id}}" class="btn blue-btn w-100">REPORT</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="comments-div">
                        <a class="" data-bs-toggle="collapse" href="#collapseExample{{$postData->id}}" role="button"
                           aria-expanded="true" aria-controls="collapseExample{{$postData->id}}">
                            Say Something <img src="/img/dropdwon.png" alt="dropdown" class="ms-1">
                        </a>
                        <div class="collapse show" id="collapseExample{{$postData->id}}">
                            <form role="form" method="POST" name="comment{{$postData->id}}" action="{{ route('comment') }}">
                                @csrf
                                <div class="comment-box">
                                    <div class="form-group">
                                        <input type="hidden" class="postID" name="post_id" value="{{$postData->id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$postData->user_id}}">
                                        <input type="text" name="comment" id="{{$postData->id}}" class="form-control ps-2 mb-0 h-100 commentOnPost">
                                    </div>
                                    <button type="submit" id="submitPost{{$postData->id}}" class="send-btn btn"><img src="/img/send.png"></button>
                                </div>
                            </form>
                            @foreach ($postData->comments as $comments)
                            <div class="comment-row">
                                <span class="comment-name">{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :
                                </span>
                                {{$comments->value}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-advertisement">
                <img src="/img/new/advertisement1.png" alt="advertisement">
                <img src="/img/new/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')

@endsection

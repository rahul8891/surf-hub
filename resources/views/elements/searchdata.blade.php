@if(isset($postsList[0]->id) && !empty($postsList[0]->id))
    @foreach ($postsList as $key => $posts)
                    @if($posts->parent_id == 0)
                <div class="post">
                    
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($posts->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($posts->user->user_profiles->first_name,0,1))}}{{ucwords(substr($posts->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}} ( {{ ucfirst($posts->user->user_name) }} )</h4>
                                    <span>{{ $posts->beach_breaks->beach_name ?? '' }} {{ $posts->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y')}}</span><br>
                                    <span>{{ postedDateTime($posts->surf_start_date) }}</span>
                                </div>
                            </div>
                            @if (isset(Auth::user()->id) && ($posts->user_id != Auth::user()->id))
                                <button class="followBtn follow <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id))?((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0'))?'clicked':'clicked Follow'):'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                    <img src="img/user.png" alt=""> FOLLOW
                                </button>
                            @endif
                        </div>
                        <p class="description">{{$posts->post_text}}</p>
                        <div class="imgRatingWrap">
                            @if(!empty($posts->upload->image))
                            <img src="{{ asset('storage/images/'.$posts->upload->image) }}" alt="" class=" img-fluid" id="myImage{{$posts->id}}">
                            @endif
                            @if(!empty($posts->upload->video))
                                @if (!File::exists(asset('storage/fullVideos/'.$posts->upload->video)))
                                <video width="100%" preload="auto" data-setup="{}" controls class="video-js" id="myImage{{$posts->id}} video-js">
                                    <source src="{{ asset('storage/fullVideos/'.$posts->upload->video) }}" >    
                                </video>
                                @else
                                <video width="100%" preload="auto" data-setup="{}" controls class="video-js" id="myImage{{$posts->id}} video-js">
                                    <source src="{{ asset('storage/videos/'.$posts->upload->video) }}" >    
                                </video>
                                @endif
                            @endif
                            
                            <div class="ratingShareWrap">
                                <ul class="pl-0 mb-0 d-flex align-items-center">
                                    <li>
                                        <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}"
                                        data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$posts->userAverageRating}}">   
                                    </li>
                                    <li class="ratingCount">
                                        <span id="average-rating{{$posts->id}}">{{intval($posts->averageRating)}}</span>
                                        (<span id="users-rated{{$posts->id}}">{{intval($posts->usersRated())}}</span>)
                                    </li>
                                </ul>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <!-- <li>
                                            <a href="#"><img src={{asset("img/instagram.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li> -->
                                        <li>
                                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url()."/postData/".$posts->id }}">                                                
                                                <img src="{{ asset("/img/facebook.png")}}" alt="">
                                            </a> 
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                                <img src={{asset("img/maps-and-flags.png")}} alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("img/full_screen.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{date('d-m-Y',strtotime($posts->surf_start_date))}}
                                                            </div>
                                                            <div class="col-5">
                                                                Surfer
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->surfer}}
                                                            </div>
                                                            <div class="col-5">
                                                                Posted By
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{ucfirst($posts->user->user_name)}}
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->beach_breaks->beach_name ?? ''}}/{{$posts->beach_breaks->break_name ?? ''}}
                                                            </div>
                                                            <div class="col-5">
                                                                Country
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->countries->name}}
                                                            </div>
                                                            <div class="col-5">
                                                                State
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->states->name??""}}
                                                            </div>
                                                            <div class="col-5">
                                                                Wave Size
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                @foreach($customArray['wave_size'] as $key => $value)
                                                                    @if($key == $posts->wave_size)
                                                                        {{$value}}
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-5">
                                                                Board Type
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->board_type}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @if(isset(Auth::user()->id) && (Auth::user()->id != $posts->user_id))
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                                        Save this video to your personal MyHub library
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">REPORT
                                                <div class="saveInfo infoHover reasonHover">
                                                    <div class="pos-rel">
                                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                                        <div class="text-center reportContentTxt">Report Content</div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report1" name="Report1"
                                                                value="Report">
                                                            <label for="Report1">Report Info as incorrect</label>
                                                        </div>
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="Report3">
                                                            <label for="Report3">Report content as inappropriate</label>
                                                        </div>
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="Report4">
                                                            <label for="Report4">Report tolls</label>
                                                        </div>
                                                        <div>
                                                            Additional Comments:
                                                            <textarea></textarea>
                                                        </div>
                                                        <button>REPORT</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @if (count($posts->comments) > 0)
                            <div class="viewAllComments">
                                @if (count($posts->comments) > 5)
                                <div class="modal" id="commentPopup">
                                  <div class="modal-dialog">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Comments</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        @foreach ($posts->comments as $comments)
                                        <p class="comment ">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                      </div>

                                      <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                                <p class="viewCommentTxt" data-toggle="modal" data-target="#commentPopup">View all comments</p>
                                @endif
                                @foreach ($posts->comments->slice(0, 5) as $comments)
                                <p class="comment ">
                                    <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                </p>
                                @endforeach
                            </div>
                            @endif
                            <div class="WriteComment">
                                <form role="form" method="POST" name="comment{{$posts->id}}" action="{{ route('comment') }}">
                                @csrf
                                <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                <input type="hidden" name="parent_user_id" value="{{$posts->user_id}}">
                                <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$posts->id}}" style="outline: none;"></textarea>
                                <button type="submit" class="btn btn-info postComment" id="submitPost{{$posts->id}}">Submit</button>
                                </form>
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
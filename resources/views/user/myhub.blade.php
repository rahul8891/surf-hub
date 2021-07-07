@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
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
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 pos-rel" id="myhub-data">
                @include('layouts/user/upload_layout')
                @if (is_null($myHubs[0]))
                <div class="post alert text-center alert-dismissible py-5" role="alert" id="msg">
                    {{ ucWords('no post found') }}
                </div>
                @elseif (!is_null($myHubs[0]))
                    @foreach ($myHubs as $key => $myHub)
                <div class="post">
                    @if($key==0)
                    <h2>My Hub</h2>
                    @endif
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($myHub->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$myHub->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($myHub->user->user_profiles->first_name,0,1))}}{{ucwords(substr($myHub->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{ucfirst($myHub->user->user_profiles->first_name)}} {{ucfirst($myHub->user->user_profiles->last_name)}} ( {{ ucfirst($myHub->user->user_name) }} )</h4>
                                    <span>{{ $myHub->beach_breaks->beach_name ?? '' }} {{ $myHub->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($myHub->created_at)->format('d-m-Y')}}</span><br>
                                    <span>{{ postedDateTime($myHub->created_at) }}</span>
                                </div>
                            </div>

                            <!-- <button href="#" class="followBtn" data-id="{{ $myHub->user_id }}" data-post_id="{{ $myHub->id }}">
                                <img src="/img/user.png" alt=""> FOLLOW
                            </button> -->
                            
                        </div>
                        <p class=" description">{{$myHub->post_text}}</p>
                                <div class="imgRatingWrap">
                                    @if(!empty($myHub->upload->image)) 
                                    <div class="pos-rel editBtnWrap">
                                        <img src="{{ asset('storage/images/'.$myHub->upload->image) }}" alt="" width="100%" class="img-fluid" id="myImage{{$myHub->id}}">
                                        <!-- <button class="editBtn editBtnVideo" data-id="{{ $myHub->id }}"><img src="/img/edit.png" class="img-fluid"></button> -->
                                    </div>
                                    @endif
                                    @if(!empty($myHub->upload->video))
                                    <br>
                                    <div class="pos-rel editBtnWrap">
                                        <video width="100%" preload="auto" data-setup="{}" controls class="video-js" id="myImage{{$myHub->id}} video-js">
                                            <source src="{{ asset('storage/videos/'.$myHub->upload->video) }}" >    
                                        </video>
                                        <!-- <button class="editBtn editBtnVideo" data-id="{{ $myHub->id }}"><img src="/img/edit.png" class="img-fluid"></button> -->
                                    </div>
                                    @endif

                                    <div class="ratingShareWrap">
                                        <ul class="pl-0 mb-0 d-flex align-items-center">
                                            <li>
                                                <input id="rating{{$myHub->id}}" name="rating" class="rating rating-loading" data-id="{{$myHub->id}}"
                                                data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$myHub->userAverageRating}}">   
                                            </li>
                                            <li class="ratingCount">
                                                <span id="average-rating{{$myHub->id}}">{{intval($myHub->averageRating)}}</span>
                                                (<span id="users-rated{{$myHub->id}}">{{intval($myHub->usersRated())}}</span>)
                                                
                                            </li>
                                        </ul>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <li>
                                                    @if(!empty($myHub->upload->image))
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$myHub->upload->image)); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @elseif(!empty($myHub->upload->video))
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$myHub->upload->video)); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @else
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$myHub->beach_breaks->latitude ?? ''}}" data-long="{{$myHub->beach_breaks->longitude ?? ''}}" data-id="{{$myHub->id}}" class="locationMap">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a onclick="openFullscreen({{$myHub->id}});"><img src="{{ asset("/img/full_screen.png")}}"
                                                            alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li class="pos-rel">
                                                    <a href="javascript:void(0)">INFO
                                                        <div class="saveInfo infoHover">
                                                            <div class="pos-rel">
                                                                <img src="{{ asset("img/tooltipArrowDown.png")}}" alt="">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        Date
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{date('d-m-Y',strtotime($myHub->surf_start_date))}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Surfer
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->surfer}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Posted By
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ ucfirst($myHub->user->user_name) }}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Beach/Break
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ $myHub->beach_breaks->beach_name ?? '' }}/{{ $myHub->beach_breaks->break_name ?? '' }}
                                                                    </div> 
                                                                    <div class="col-5">
                                                                        Country
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->countries->name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        State
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->states->name??""}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Wave Size
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        @foreach($customArray['wave_size'] as $key => $value)
                                                                            @if($key == $myHub->wave_size)
                                                                                {{$value}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Board Type
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->board_type}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="{{route('deleteUserPost', Crypt::encrypt($myHub->id))}}"  onclick="return confirm('Do you really want to delete this footage?')">DELETE</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li class="pos-rel">
                                                    @if (count($myHub->tags) >= 1)
                                                    <div class="modal" id="postTag{{$myHub->id}}">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">

                                                          <!-- Modal Header -->
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Tagged Users</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          </div>

                                                          <!-- Modal body -->
                                                          <div class="modal-body">
                                                            @foreach ($myHub->tags as $tags)
                                                            <p class="comment ">
                                                                <div class="post-head">
                                                                <div class="userDetail">
                                                                @if($tags->user->profile_photo_path)
                                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="profileImg" alt="">
                                                                @else
                                                                <div class="profileImg no-image">
                                                                    {{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}
                                                                </div>
                                                                @endif
                                                                <span>{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>
                                                                </div>
                                                            </div>
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
                                                    @endif
                                                    <!-- <a data-toggle="modal" data-target="#postTag{{$myHub->id}}">TAG -->
                                                    <a href="javascript:void(0)">TAG
                                                        
                                                        <div class="saveInfo infoHover userinfoModal">
                                                            <div class="pos-rel">
                                                                <img src="../../../img/tooltipArrowDown.png" alt="">
                                                                <div class="scrollWrap">
                                                                    @foreach ($myHub->tags->reverse() as $tags)
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                            @if($tags->user->profile_photo_path)
                                                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="taggedUserImg" alt="">
                                                                                
                                                                            @else
                                                                                <div class="taggedUserImg no-image">
                                                                                    {{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}
                                                                                </div>
                                                                            @endif
                                                                            </div>
                                                                            <span class="userName">{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>                                                                         
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-12 col-sm-4" id="tagUser">
                                                                    <div class="selectWrap pos-rel">
                                                                        <div class="selectWrap pos-rel">
                                                                            <input type="text" value="{{ old('tag_user')}}" name="tag_user"
                                                                                placeholder="@ Search user" class="form-control tag_user" required data-post_id="{{$myHub->id}}">
                                                                                <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                                                id="user_id" class="form-control user_id">
                                                                            <div class="auto-search tagSearch" id="tag_user_list{{$myHub->id}}"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                        
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if (count($myHub->comments) > 0)
                                    <div class="viewAllComments">
                                        @if (count($myHub->comments) > 5)
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
                                                @foreach ($myHub->comments as $comments)
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
                                        @foreach ($myHub->comments->slice(0, 5) as $comments)
                                        <p class="comment ">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="WriteComment">
                                        <form role="form" method="POST" name="comment{{$myHub->id}}" action="{{ route('comment') }}">
                                        @csrf
                                        <input type="hidden" class="postID" name="post_id" value="{{$myHub->id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$myHub->user_id}}">
                                        <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$myHub->id}}" style="outline: none;"></textarea>
                                        <button type="submit" class="btn btn-info postComment" id="submitPost{{$myHub->id}}">Submit</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    
                    <div class=""></div>
                    <div class="ajax-load ajax-loadBtm" style="display:none">
                        <div class="letter-holder">
                            <div class="load-6">
                                <div class="letter-holder">
                                <div class="l-1 letter">L</div>
                                <div class="l-2 letter">o</div>
                                <div class="l-3 letter">a</div>
                                <div class="l-4 letter">d</div>
                                <div class="l-5 letter">i</div>
                                <div class="l-6 letter">n</div>
                                <div class="l-7 letter">g</div>
                                <div class="l-8 letter">.</div>
                                <div class="l-9 letter">.</div>
                                <div class="l-10 letter">.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-3">
                    <div class="adWrap">
                        <img src="{{ asset("/img/add1.png")}}" alt="" class="img-fluid">
                    </div>
                    <div class="adWrap">
                        <img src="{{ asset("/img/add2.png")}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
</section>
@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')
@include('layouts/models/edit_image_upload')
@include('layouts/models/edit_video_upload')

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" type="text/javascript"></script>
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
<script type="text/javascript">
	var page = 1;
        
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});

	function loadMoreData(page) { 
            $.ajax({
                url: '?page=' + page,
                type: "get",
                beforeSend: function() {
                    $('.ajax-load').delay(1500).show();
                }
            })
            .done(function(data) {
                if(data.html == "") {
                    $('.ajax-load').html("No more records found");
                    return;
                }
                
                $("#myhub-data").append(data.html);
            });
	}
        
        $(".editBtnImage").click(function() {
            var id = $(this).data('id');
            
             $.ajax({
                url: '/getPostData/'+id+'/image',
                type: "get",
            })
            .done(function(data) {
                $("#edit_video_upload").html("");
                $("#edit_image_upload").append(data.html);
                $("#edit_image_upload").modal('toggle');
            });
        });
        
        $(".editBtnVideo").click(function() {
            var id = $(this).data('id');
            
             $.ajax({
                url: '/getPostData/'+id+'/video',
                type: "get",
            })
            .done(function(data) {
                $("#edit_video_upload").html("");
                $("#edit_video_upload").append(data.html);
                $("#edit_video_upload").modal('toggle');
            });
        });
        
    Dropzone.autoDiscover = false;

    $('#imageUploads').dropzone({
        paramName: 'photos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your images",
        acceptedFiles: ".png, .jpg, .jpeg",
        clickable: true,
        enqueueForUpload: true,
        maxFilesize: 100,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".uploadPost").removeAttr("disabled");
            $(".uploadPost").removeClass("clicked");
            $(".uploadPost").text("Upload");
            $(".uploadImageFiles").append('<input type="hidden" id="" name="files[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        },
        sending: function(file, response, formData){
            $(".uploadPost").attr("disabled", "true");
            $(".uploadPost").addClass("clicked");
            $(".uploadPost").text("Loading Files....");
            
        }
    });

    $('#videoUploads').dropzone({
        paramName: 'videos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your videos",
        clickable: true,
        acceptedFiles: ".mp4, .wmv, .mkv, .gif, .mpeg4, .mov",
        enqueueForUpload: true,
        maxFilesize: 1000,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".uploadPost").removeAttr("disabled");
            $(".uploadPost").removeClass("clicked");
            $(".uploadPost").text("Upload");
            $(".uploadVideoFiles").append('<input type="hidden" id="" name="videos[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        },
        sending: function(file, response, formData){
            $(".uploadPost").attr("disabled", "true");
            $(".uploadPost").addClass("clicked");
            $(".uploadPost").text("Loading Files....");
            
        }
    });
        
    $('#editImageUploads').dropzone({
        paramName: 'photos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your images",
        acceptedFiles: ".png, .jpg, .jpeg",
        clickable: true,
        enqueueForUpload: true,
        maxFilesize: 1,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".editUploadImageFiles").append('<input type="hidden" id="" name="files[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        }
    });

    $('#editVideoUploads').dropzone({
        paramName: 'videos',
        url: '{{ route("uploadFiles") }}',
        dictDefaultMessage: "Drag your videos",
        clickable: true,
        acceptedFiles: ".mp4, .wmv, .mkv, .gif, .mpeg4, .mov",
        enqueueForUpload: true,
        maxFilesize: 1,
        uploadMultiple: true,
        addRemoveLinks: false,
        success: function (file, response) {
            $(".editUploadVideoFiles").append('<input type="hidden" id="" name="videos[]" value="'+response.success+'" />');
        },
        error: function (file, response) {
            console.log("something goes wrong");
        }
    });
</script>
@endsection

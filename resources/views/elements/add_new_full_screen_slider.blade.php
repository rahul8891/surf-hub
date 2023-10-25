
            @if (!empty($postsList))
                @php
                $firstSlide = 0;
                $newIndex = $lastIndex+1;
                @endphp
            @foreach ($postsList as $key => $posts)
                @php
                    if($posts->id == $id) {
                        $firstSlide = $key;
                    }
                @endphp
                
                <div class="slick-slide" data-slick-index="{{$newIndex}}" aria-hidden="true" tabindex="-1" style="width: 1526px; position: relative; left: -13734px; top: 0px; z-index: 998; opacity: 0;">
                    <div>
                        <div class="newsFeedImgVideoSlider newPostsSlide" data-id="{{$posts->id}}">
                            @if (isset($posts->parent_id) && ($posts->parent_id > 0))
                                @if(!empty($posts->upload->image))
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->parent_id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                @elseif(!empty($posts->upload->video))
                                    <div class="jw-video-slider-player" style="height:700px;" id="myVid{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->parent_id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}"  data-id="{{$posts->id}}">
                                        <video width="100%" preload="true" controls playsinline muted class="video-js" id="myVideoTags{{$posts->id}}" autoplay oncanplay="focusPlay({{ $posts->id }})">
                                        </video>
                                    </div>
                                @endif
                            @else
                                @if(!empty($posts->upload->image))
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                @elseif(!empty($posts->upload->video))
                                    <div class="jw-video-slider-player" style="height:700px;" id="myVid{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}"  data-id="{{$posts->id}}">
                                        <video width="100%" preload="true" autoplay controls playsinline muted class="video-js" id="myVideoTags{{$posts->id}}" oncanplay="focusPlay({{ $posts->id }})">
                                        </video>
                                    </div>
                                @endif
                            @endif
                            <div class="overlayDetails">
                                <span class="spacing">{{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }}</span>
                                <span class="spacing">{{ (isset($posts->surfer) && !empty($posts->surfer))?ucfirst($posts->surfer):"SurfHub" }}</span>
                                <span class="spacing">{{ (isset($posts->beach_breaks->beach_name))?$posts->beach_breaks->beach_name:'' }} {{ (isset($posts->breakName->break_name))?$posts->breakName->break_name:'' }}</span>
                                <span>{{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
               @php $newIndex++; @endphp
            @endforeach
            @endif
        
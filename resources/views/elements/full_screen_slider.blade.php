<style>
    .modal-dialog {
        max-width: 1350px !important;
        max-height: 700px !important;
    }
    .vjs-loading-spinner {
        display: none !important;
    }
</style>

<div class="modal-dialog editPostM " role="document">
    <div class="modal-content">
        <div class="position-absolute w-100 top-0">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
        <div class="">
            <button  class="btn spotify-btn" id='togglePlay' >
                <img src="/img/listen-on-spotify-button.png" alt=""></img>
            </button>
            <button  class="btn spotify-pause-btn d-none" id='pause-song' >
                <img src="/img/pause.png">
            </button>
            <button  class="btn spotify-pause-btn d-none" id='play-song' >
                <img src="/img/play.png">
            </button>
        </div>

        <!-- Carousel wrapper -->
        <div class="slider demo full-screen-slider post-slider">
            @if (!empty($postsList))
                @php
                $firstSlide = 0;
                @endphp
            @foreach ($postsList as $key => $posts)
                @php
                    if($posts->id == $id) {
                        $firstSlide = $key;
                    }
                @endphp
                <div class="newsFeedImgVideoSlider" data-id="{{$posts->id}}">
                    @if(Auth::user())
                        @if(!empty($token))
                            <!-- <button  class="btn spotify-btn" id='togglePlay'><img src="/img/listen-on-spotify-button.png" alt=""></button> -->
                        @else
                            <!-- <a href="{{route('spotify-auth')}}" target="_blank" class="btn spotify-btn" id='togglePlay'>
                                <picture>
                                    <source media="(min-width:575px)"  srcset="/img/listen-on-spotify-button.png">
                                    <img src="/img/new/spotify.png" style="height:40px;"  alt="Flowers" style="width:auto;">
                                </picture>
                            </a> -->
                        @endif
                    @endif

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
                </div>
            @endforeach
            @endif
        </div>
        <div class="col-md-12 text-center mb-2">
            <button id="toggle" class="btn btn-primary col-md-2 text-white">
                <span class="d-sm-block d-none play_pause">Play</span>
                <img style="width:40px;border-radius:50%;" class="d-sm-none d-block" src="/img/new/play.jpg">
            </button>
        </div>
    </div>
</div>

<script src="https://vjs.zencdn.net/5.19.2/video.js"></script>
<script src="{{ asset('/js/hls/hls.min.js?v=v0.9.1') }}"></script>
<script src="{{ asset('/js/hls/videojs5-hlsjs-source-handler.min.js?v=0.3.1') }}"></script>
<script src="{{ asset('/js/hls/vjs-quality-picker.js?v=v0.0.2') }}"></script>
<script src="https://sdk.scdn.co/spotify-player.js"></script>

<script>
    jQuery.noConflict();

    window.HELP_IMPROVE_VIDEOJS = false;

    jQuery( ".jw-video-slider-player" ).each(function() {
        var playerHeight = window.innerHeight ;
        jQuery(this).css("height", playerHeight);

        var videoID = 'myVideoTags'+$(this).attr('data-id');
        var videoUrl = $(this).attr('data-src');
        console.log("Data = myVideoTag ----     "+videoID+"  --  "+videoUrl);
        var options = {};

        videojs(videoID).ready(function () {
            var myPlayer = this;
            myPlayer.qualityPickerPlugin();

            myPlayer.src({
                type: 'application/x-mpegURL',
                src: videoUrl
            });

        });
    });



    function focusPlay(post_id) {
        // console.log('aaaaa = '+post_id);
        // document.getElementById('myVideoTags' + post_id).play(true);
        videojs('myVideoTags' + post_id).ready(function () {
            var myPlayer = this;
            myPlayer.play();
        });
    }

    const token = @json($token);
    const track_uri = @json($trackArray['track_uri']);
    //// Play selected song


    // window.onSpotifyWebPlaybackSDKReady = () => {
    //     const token = @json($token);
    //     const track_uri = @json($trackArray['track_uri']);
    //     // Define the Spotify Connect device, getOAuthToken has an actual token
    //     // hardcoded for the sake of simplicity
    //     var player = new Spotify.Player({
    //     name: 'A Spotify Web SDK Player',
    //             getOAuthToken: callback => {
    //             callback(token);
    //             },
    //             volume: 0.1
    //     });
    //     // Called when connected to the player created beforehand successfully
    //     player.addListener('ready', ({ device_id }) => {
    //         console.log('Ready with Device ID', device_id);
    //         const play = ({
    //         spotify_uri,
    //             playerInstance: {
    //                 _options: {
    //                     getOAuthToken,
    //                     id
    //                 }
    //             }
    //         }) => {
    //             getOAuthToken(access_token => {
    //                 fetch(`https://api.spotify.com/v1/me/player/play?device_id=${device_id}`, {
    //                     method: 'PUT',
    //                     body: JSON.stringify({ uris: [spotify_uri] }),
    //                     headers: {
    //                         'Content-Type': 'application/json',
    //                         'Authorization': `Bearer ${access_token}`
    //                     },
    //                 });
    //             });
    //         };

    //         play({
    //             playerInstance: player,
    //             spotify_uri: track_uri,
    //         });
    //     });

    //     // Connect to the player created beforehand, this is equivalent to
    //     // creating a new device which will be visible for Spotify Connect
    //     player.connect();
    // };





    window.onSpotifyWebPlaybackSDKReady = () => {

        const player = new Spotify.Player({
            name: "Music Player",
            getOAuthToken: (cb) => {
            cb(token);
            },
            volume: 0.5,
    });

  // Player Ready
  player.addListener("ready", ({ device_id }) => {
    console.log("Ready with Device ID", device_id);

    // After player is ready, change current device to this player
    const connect_to_device = () => {
      let change_device = fetch("https://api.spotify.com/v1/me/player", {
        method: "PUT",
        body: JSON.stringify({
          device_ids: [device_id],
          play: false,
        }),
        headers: new Headers({
          Authorization: "Bearer " + token,
        }),
      }).then((response) => console.log(response));
    };
    connect_to_device();
  });

  // Not Ready
  player.addListener("not_ready", ({ device_id }) => {
    console.log("Device ID has gone offline", device_id);
  });

  // Error Handling
  player.addListener("initialization_error", ({ message }) => {
    console.error(message);
  });
  player.addListener("authentication_error", ({ message }) => {
    console.error(message);
  });
  player.addListener("account_error", ({ message }) => {
    console.error(message);
  });

  // Start device connection
  player.connect().then((success) => {
    if (success) {
      console.log("The Web Playback SDK successfully connected to Spotify!");
    }
  });

  // Toggle Play Button
//   document.getElementById("togglePlay").onclick = function () {
//     player.togglePlay();
//   };
document.getElementById("togglePlay").onclick = function () {
        console.log("Changing song");
        let request_answer = fetch(
            `https://api.spotify.com/v1/me/player/play`,
            {
                method: "PUT",
                body: JSON.stringify({ uris: [track_uri] }),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
            }
        ).then(() => {
            document.getElementById("pause-song").classList.remove("d-none");
            });
    }

    document.getElementById("pause-song").onclick = function () {
        player.pause().then(() => {
            document.getElementById("pause-song").classList.add("d-none");
            document.getElementById("play-song").classList.remove("d-none");
        });
    }
    document.getElementById("play-song").onclick = function () {
        player.resume().then(() => {
            document.getElementById("pause-song").classList.remove("d-none");
            document.getElementById("play-song").classList.add("d-none");
        });
    }

};


// Play selected song








    // jQuery('.post-slider').slick('refresh');

    jQuery(document).ready(function () {
        var homeCarousel = jQuery('.post-slider').slick({
            refresh: true,
            dots: false,
            fade: true,
            pauseOnHover: false,
            arrows: true,
            infinite: false,
            autoplay: false,
            autoplaySpeed: 3000,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: false,
            initialSlide: <?php echo $firstSlide; ?>,
        });

        jQuery('.post-slider').on('afterChange', function(event, slick, currentSlide) {
            var vid = jQuery(slick.$slides[currentSlide]).find('video');
            if (vid.length > 0) {
                if (jQuery('#toggle').find('.play_pause').html() == 'Pause'){
                    jQuery('.post-slider').slick('slickPause')
                        .slick('slickSetOption', 'pauseOnDotsHover', false)
                        .slick('slickSetOption', 'autoplay', false)
                        .slick('slickSetOption', 'autoplaySpeed', 3000);
                }

                jQuery(vid).get(0).play();
            }
        });

        jQuery('video').on('ended',function(){
            console.log('Video Complete')
            if (jQuery('#toggle').find('.play_pause').html() == 'Pause'){
                jQuery('.post-slider').slick('slickPlay')
                    .slick('slickSetOption', 'pauseOnDotsHover', true)
                    .slick('slickSetOption', 'autoplay', true)
                    .slick('slickSetOption', 'autoplaySpeed', 3000);
            }
        });

        jQuery(document).on('click', '#toggle', function () {
            if (jQuery(this).find('.play_pause').html() == 'Pause'){
                jQuery('.slider').slick('slickPause')
                    .slick('slickSetOption', 'pauseOnDotsHover', false)
                    .slick('slickSetOption', 'autoplay', false)
                    .slick('slickSetOption', 'autoplaySpeed', 3000);
                let playbutton = `<span class="d-sm-block d-none play_pause">Play</span>
                    <img style="width:40px;border-radius:50%;" class="d-sm-none d-block" src="/img/new/play.jpg">`;
                jQuery(this).html(playbutton);
            } else {
                jQuery('.slider')
                    .slick('slickPlay')
                    .slick('slickSetOption', 'pauseOnDotsHover', true)
                    .slick('slickSetOption', 'autoplay', true)
                    .slick('slickSetOption', 'autoplaySpeed', 3000);
                let pausebutton = `<span class="d-sm-block d-none play_pause">Pause</span>
                    <img style="width:40px;border-radius:50%;" class="d-sm-none d-block" src="/img/new/pause.jpeg">`;
                jQuery(this).html(pausebutton);
            }
        });

        // jQuery(document).on('click', '#togglePlay', function () {
        //     console.log('hhhhhhhhhhhhh');
        // });
    });
</script>

<style>
    .modal-dialog {
        max-width: 1350px !important;
        max-height: 700px !important;
    }
</style>

<div class="modal-dialog editPostM " role="document">
    <div class="modal-content">

        <!-- Carousel wrapper -->
        <div class="slider demo">
            @if (!empty($postsList))
            @foreach ($postsList as $key => $posts)

            @if(!empty($posts->upload->image))
            <div class="newsFeedImgVideoSlider">
                @if(!empty($token))
                <button  class="btn spotify-btn" id='togglePlay'><img src="/img/listen-on-spotify-button.png" alt=""></button>
                @else
                <a href="{{route('spotify-auth')}}" target="_blank" class="btn spotify-btn" id='togglePlay'><img src="/img/listen-on-spotify-button.png" alt=""></a>
                @endif
                <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
            </div>
            @elseif(!empty($posts->upload->video))
            @if (!File::exists($posts->upload->video))
            <div class="newsFeedImgVideoSlider">
                @if(!empty($token))
                <button onClick="play_song('{{ isset($trackArray['track_uri'])?$trackArray['track_uri']:'' }}')" class="btn spotify-btn"><img src="/img/listen-on-spotify-button.png" alt=""></button>
                @else
                <a href="{{route('spotify-auth')}}" target="_blank" class="btn spotify-btn" id='togglePlay'><img src="/img/listen-on-spotify-button.png" alt=""></a>
                @endif

                <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                    <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}">
                </video>
            </div>    
            @else
            <div class="newsFeedImgVideoSlider">
                @if(!empty($token))
                <button onClick="play_song('{{ isset($trackArray['track_uri'])?$trackArray['track_uri']:'' }}')" class="btn spotify-btn"><img src="/img/listen-on-spotify-button.png" alt=""></button>
                @else
                <a href="{{route('spotify-auth')}}" target="_blank" class="btn spotify-btn" id='togglePlay'><img src="/img/listen-on-spotify-button.png" alt=""></a>
                @endif

                <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                    <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}">
                </video>
                <!--<audio controls src="{{ $getTrack['external_urls']['spotify']}}"></audio>-->
            </div>
            @endif
            @endif


            @endforeach
            @endif

        </div>
        <div class="col-md-12 text-center mb-2">
            <button id="toggle" class="btn btn-primary col-md-2 text-white">Play</button>

        </div>

    </div>
</div>

<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script>


//window.onSpotifyWebPlaybackSDKReady = () => {
////    const device_id = '47e5b24b028ce85508d27a9f1961896ad413aed4';
//    const token = @json($token);
//    const track_uri = @json($trackArray['track_uri']);
//    const player = new Spotify.Player({
//        name: "Test",
//        getOAuthToken: (cb) => {
//            cb(token);
//        },
//        volume: 0.5,
//    });
//
//    // Player Ready
//    player.addListener("ready", ({ device_id }) => {
//        console.log("Ready with Device ID", device_id);
//
//        // After player is ready, change current device to this player
//        const connect_to_device = () => {
//            console.log("Changing to device");
//            let change_device = fetch("https://api.spotify.com/v1/me/player/play", {
//                method: "PUT",
//                body: JSON.stringify({
//                    uris: [track_uri],
//                }),
//                headers: new Headers({
//                    Authorization: "Bearer " + token,
//                }),
//            }).then((response) => console.log(response));
//        };
//        connect_to_device();
//    });
//
//    // Not Ready
//    player.addListener("not_ready", ({ device_id }) => {
//        console.log("Device ID has gone offline", device_id);
//    });
//
//    // Error Handling
//    player.addListener("initialization_error", ({ message }) => {
//        console.error(message);
//    });
//    player.addListener("authentication_error", ({ message }) => {
//        console.error(message);
//    });
//    player.addListener("account_error", ({ message }) => {
//        console.error(message);
//    });
//
//    // Start device connection
//    player.connect().then((success) => {
//        if (success) {
//            console.log("The Web Playback SDK successfully connected to Spotify!");
//        }
//    });
//
//    // Toggle Play Button
//    document.getElementById("togglePlay").onclick = function () {
//        player.togglePlay();
//    };
//
//};
//
//// Play selected song
                    const play_song = async (uri) => {
                    console.log("Changing song");
                    let request_answer = fetch(
                            `https://api.spotify.com/v1/me/player/play?device_id=${device_id}`,
                    {
                    method: "PUT",
                            body: JSON.stringify({ uris: [uri] }),
                            headers: {
                            'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${access_token}`
                            },
                    }
                    ).then((data) => console.log(data));
                    };
                    window.onSpotifyWebPlaybackSDKReady = () => {
                    const token = @json($token);
                    const track_uri = @json($trackArray['track_uri']);
                    // Define the Spotify Connect device, getOAuthToken has an actual token 
                    // hardcoded for the sake of simplicity
                    var player = new Spotify.Player({
                    name: 'A Spotify Web SDK Player',
                            getOAuthToken: callback => {
                            callback(token);
                            },
                            volume: 0.1
                    });
                    // Called when connected to the player created beforehand successfully
                    player.addListener('ready', ({ device_id }) => {
                    console.log('Ready with Device ID', device_id);
                    const play = ({
                    spotify_uri,
                            playerInstance: {
                            _options: {
                            getOAuthToken,
                                    id
                            }
                            }
                    }) => {
                    getOAuthToken(access_token => {
                    fetch(`https://api.spotify.com/v1/me/player/play?device_id=${device_id}`, {
                    method: 'PUT',
                            body: JSON.stringify({ uris: [spotify_uri] }),
                            headers: {
                            'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${access_token}`
                            },
                    });
                    });
                    };
                    play({
                    playerInstance: player,
                            spotify_uri: track_uri,
                    });
                    });
                    // Connect to the player created beforehand, this is equivalent to 
                    // creating a new device which will be visible for Spotify Connect
                    player.connect();
                    };
                    $(document).ready(function () {
                    var homeCarousel = $('.demo').slick({
                    dots: true,
                            fade: true,
                            pauseOnHover: false,
                            arrows: true,
                            infinite: true,
                            autoplay: false,
                            autoplaySpeed: 3000,
                            speed: 300,
                            slidesToShow: 1,
                            adaptiveHeight: false
                    });
                    $(document).on('click', '#toggle', function () {
                    if ($(this).html() == 'Pause'){
                    $('.slider').slick('slickPause')
                            .slick('slickSetOption', 'pauseOnDotsHover', false)
                            .slick('slickSetOption', 'autoplay', false)
                            .slick('slickSetOption', 'autoplaySpeed', 3000);
                    $(this).html('Play')
                    } else {
                    $('.slider')
                            .slick('slickPlay')
                            .slick('slickSetOption', 'pauseOnDotsHover', true)
                            .slick('slickSetOption', 'autoplay', true)
                            .slick('slickSetOption', 'autoplaySpeed', 3000);
                    $(this).html('Pause')
                    }
                    });
                    });
</script>
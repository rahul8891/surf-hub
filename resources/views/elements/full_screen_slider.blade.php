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
                <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
            </div>
            @elseif(!empty($posts->upload->video))
            @if (!File::exists($posts->upload->video))
            <div class="newsFeedImgVideoSlider">
                <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                    <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                </video>
            </div>    
            @else
            <div class="newsFeedImgVideoSlider">
                <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                    <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                </video>
            </div>
            @endif
            @endif


            @endforeach
            @endif
            
        </div>
<!--        <button id="pause">Pause!</button>
        <button id="play">play!</button>-->
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>    
<script>

$(document).ready(function () {
    var homeCarousel = $('.demo').slick({
        dots: true,
        fade: true,
        pauseOnHover: false,
        arrows: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 1000,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: false
    });
    
    
    $('#pause').click(function() {
	$('.demo')
          .slick('slickPause')
          .slick('slickSetOption', 'pauseOnDotsHover', false)
          .slick('slickSetOption', 'autoplay', false)
          .slick('slickSetOption', 'autoplaySpeed', 1000);
});
$('#play').click(function() {
        $('.demo')
          .slick('slickPlay')
          .slick('slickSetOption', 'pauseOnDotsHover', true)
          .slick('slickSetOption', 'autoplay', true)
          .slick('slickSetOption', 'autoplaySpeed', 1000);
});
    
});


</script>
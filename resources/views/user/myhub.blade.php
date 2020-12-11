@extends('layouts.user.user') @section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @include('layouts/user/upload_layout')





                <div class="post">
                        <div class="head">
                                <div class="col-md-6">
                                    <img src="{{ asset("/img/photo.png")}}" alt=""> Image Gallery
                                </div>
                        </div>
                        <div class="post-head">
                            <div class="col-md-12 gallery-scroll">
                              
                                <div class="gallery" id="gallery">
                                    <div class="row"> 
                                       
                                @foreach($post as $postMedia)
                                <div class="">
                                    <h3 class="text-muted text-md">{{($postMedia->image!=null) ? $postMedia->beach_breaks->beach_name.','.$postMedia->beach_breaks->country : null}}</h3>
                                    <hr/>
                                    <div class="row no-gutters mb-4">
                                        @if (!empty($postMedia->image))
                                        @foreach (explode(' ',$postMedia->image) as $postImage)
                                    <div class="col-lg-3 col-md-4 col-4">
                                        <div class="img-container">
                                            <a href="{{asset('storage/images/'.$postImage)}}" data-toggle="lightbox" data-gallery="example-gallery">
                                            <img src="{{ asset('storage/images/'.$postImage) }}" id="myhub_images" class="img-thumbnail" alt="No photo attached">
                                            </a>
                                        </div>
                                        
                                    </div>  
                                    @endforeach
                                    @endif
                                </div>
                                </div>
                                @endforeach
                                       

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="post p-0 ">
                    <div class="uploadWrap">
                        <div class="head">
                                <div class="col-md-6">
                                    <img src="{{ asset("/img/video.png")}}" alt=""> Video Gallery
                                </div>
                        </div>
                        <div class="post-head">
                            <div class="col-md-12">
                            
                                <div class="gallery" id="gallery">
                                    <div class="row"> 
                                @foreach($post as $postMedia)
                                @if (!empty($postMedia->video))
                                @foreach (explode(' ',$postMedia->video) as $postVideo)
                                <div class="col-lg-4 col-md-4 col-4">
                                    <video width="200" height="150" controls="true">
                                    <source src="{{ asset('storage/videos/'.$postVideo) }}" type="" />
                                    </video>
                                </div>
                                @endforeach
                                @endif
                                @endforeach 
                                       

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




               

            </div>
            <div class="col-lg-3">
                <div class="adWrap">
                    <img src="{{ asset("/img/add1.png") }}" alt=""
                    class="img-fluid">
                </div>
                <div class="adWrap">
                    <img src="{{ asset("/img/add2.png") }}" alt=""
                    class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts/models/upload_video_photo') @endsection

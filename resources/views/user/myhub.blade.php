@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @include('layouts/user/upload_layout')
                <div class="post">
                    <h2>My Feed</h2>
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                <div class="profileImg no-image">
                                    EN
                                </div>
                                <div class="pl-3">
                                    <h4>Upender</h4>
                                    <span>8 hrs</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="{{ asset("/img/user.png")}}"" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class=" description">Your post message text goes in this area, you can edit it easily
                                according to your
                                needs,
                                enjoy.</p>
                                <div class="imgRatingWrap">
                                    <img src="{{ asset("/img/post1.jpg")}}"" alt="" class=" img-fluid">
                                    <div class="ratingShareWrap">
                                        <div class="rating ">
                                            <ul class="pl-0 mb-0 d-flex align-items-center">
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star-grey.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span>4.0(90)</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/instagram.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/full_screen.png")}}"
                                                            alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">INFO</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">DELETE</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">TAG</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="WriteComment">
                                        <textarea placeholder="Write a comment.."></textarea>
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
@include('layouts/models/upload_video_photo')
@endsection
@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <!--include comman upload video and photo layout -->
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
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">Your post message text goes in this area, you can edit it easily
                            according to your
                            needs,
                            enjoy.</p>
                        <div class="imgRatingWrap">
                            <img src="img/post1.jpg" alt="" class="img-fluid">
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star-grey.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src="img/instagram.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/maps-and-flags.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/full_screen.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                09-10-2020
                                                            </div>
                                                            <div class="col-5">
                                                                Surf
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Username
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Upender
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Country
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                India
                                                            </div>
                                                            <div class="col-5">
                                                                State
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Uttarakhand
                                                            </div>
                                                            <div class="col-5">
                                                                Wave Size
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                22
                                                            </div>
                                                            <div class="col-5">
                                                                Board Type
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
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
                                                        <img src="img/tooltipArrowDown.png" alt="">
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
                                    </ul>
                                </div>
                            </div>
                            <div class="WriteComment">
                                <textarea placeholder="Write a comment.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                <div class="profileImg">
                                    <img src="img/johan.png" class="img-fluid" alt="">
                                </div>
                                <div class="pl-3">
                                    <h4>Johan</h4>
                                    <span>10 hrs</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">Your post message text goes in this area, you can edit it easily
                            according to your needs,
                            enjoy.</p>
                        <div class="imgRatingWrap">
                            <div class="videoWrap pos-rel">
                                <img src="img/post2.jpg" alt="" class="img-fluid ">
                                <a href="#" class="playBtn"><img alt="" src="img/playBtn.png"></a>
                            </div>
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star-grey.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src="img/instagram.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/maps-and-flags.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/full_screen.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                09-10-2020
                                                            </div>
                                                            <div class="col-5">
                                                                Surf
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Username
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Upender
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Country
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                India
                                                            </div>
                                                            <div class="col-5">
                                                                State
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Uttarakhand
                                                            </div>
                                                            <div class="col-5">
                                                                Wave Size
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                22
                                                            </div>
                                                            <div class="col-5">
                                                                Board Type
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
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
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="text-center reportContentTxt">Report Content</div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report5" name="Report1"
                                                                value="Report">
                                                            <label for="Report5">Report Info as incorrect</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report6" name="Report6"
                                                                value="Report">
                                                            <label for="Report6">Report content as inappropriate</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report7" name="Report7"
                                                                value="Report">
                                                            <label for="Report7">Report tolls</label>
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
                                    </ul>
                                </div>
                            </div>
                            <div class="viewAllComments">
                                <p class="viewCommentTxt">View all comments</p>
                                <p class="comment ">
                                    <span>Upender Rawat :</span> Your post message text goes in this area, you
                                    can edit it easily..
                                </p>
                            </div>
                            <div class="WriteComment">
                                <textarea placeholder="Write a comment.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                <div class="profileImg">
                                    <img src="img/Tom.png" class="img-fluid">
                                </div>
                                <div class="pl-3">
                                    <h4>Tom</h4>
                                    <span>18 hrs</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">Your post message text goes in this area, you can edit it easily
                            according to your needs,
                            enjoy.</p>
                        <div class="imgRatingWrap">
                            <img src="img/post3.jpg" alt="" class="img-fluid ">
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star-grey.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src="img/instagram.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/maps-and-flags.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/full_screen.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                09-10-2020
                                                            </div>
                                                            <div class="col-5">
                                                                Surf
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Username
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Upender
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Country
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                India
                                                            </div>
                                                            <div class="col-5">
                                                                State
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Uttarakhand
                                                            </div>
                                                            <div class="col-5">
                                                                Wave Size
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                22
                                                            </div>
                                                            <div class="col-5">
                                                                Board Type
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
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
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="text-center reportContentTxt">Report Content</div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report1" name="Report11"
                                                                value="Report">
                                                            <label for="Report11">Report Info as incorrect</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report31" name="Report3"
                                                                value="Report">
                                                            <label for="Report31">Report content as
                                                                inappropriate</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report2" name="Report21"
                                                                value="Report">
                                                            <label for="Report21">Report tolls</label>
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
                                    </ul>
                                </div>
                            </div>
                            <div class="viewAllComments">
                                <p class="viewCommentTxt">View all comments</p>
                                <p class="comment ">
                                    <span>Upender Rawat :</span> Your post message text goes in this area, you
                                    can edit it easily..
                                </p>
                                <p class="comment ">
                                    <span>Johan :</span> Your post message text goes in this area, you can edit
                                    it easily..
                                </p>
                            </div>
                            <div class="WriteComment">
                                <textarea placeholder="Write a comment.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post">
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                <div class="profileImg">
                                    <img src="img/Tom.png" class="img-fluid">
                                </div>
                                <div class="pl-3">
                                    <h4>Tom</h4>
                                    <span>18 hrs</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">Your post message text goes in this area, you can edit it easily
                            according to your needs,
                            enjoy.</p>
                        <div class="imgRatingWrap">
                            <img src="img/post4.jpg" alt="" class="img-fluid ">
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star-grey.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src="img/instagram.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/maps-and-flags.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/full_screen.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                09-10-2020
                                                            </div>
                                                            <div class="col-5">
                                                                Surf
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Username
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Upender
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                            <div class="col-5">
                                                                Country
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                India
                                                            </div>
                                                            <div class="col-5">
                                                                State
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                Uttarakhand
                                                            </div>
                                                            <div class="col-5">
                                                                Wave Size
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                22
                                                            </div>
                                                            <div class="col-5">
                                                                Board Type
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                text
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
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
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="text-center reportContentTxt">Report Content</div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report01" name="Report1"
                                                                value="Report">
                                                            <label for="Report01">Report Info as incorrect</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report03" name="Report3"
                                                                value="Report">
                                                            <label for="Report03">Report content as
                                                                inappropriate</label>
                                                        </div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report02" name="Report2"
                                                                value="Report">
                                                            <label for="Report02">Report tolls</label>
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
                                    </ul>
                                </div>
                            </div>
                            <div class="viewAllComments">
                                <p class="viewCommentTxt">View all comments</p>
                                <p class="comment ">
                                    <span>Upender Rawat :</span> Your post message text goes in this area, you
                                    can edit it easily..
                                </p>
                                <p class="comment ">
                                    <span>Johan :</span> Your post message text goes in this area, you can edit
                                    it easily..
                                </p>
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
                    <img src="img/add1.png" alt="" class="img-fluid">
                </div>
                <div class="adWrap">
                    <img src="img/add2.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts/models/upload_video_photo')
@endsection
@extends('layouts.static_pages')
@section('content')
<div class="feedHubNav ">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <ul class="mb-0 pl-0">
                    <li class="hover-no">
                        <a href="javascript:void(0);">{{ __('Contact Us') }}</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
<section class="loginWrap changePswd">
    <div class="innerWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="formWrap">
                        <div class="row">

                            <div class="col-lg-9">
                                <!-- <h2>Contact US</h2> -->
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore
                                    et dolore magna aliqua.</p>
                                <div class="form">
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="Name" placeholder="Name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="Email" placeholder="Email" class="form-control">

                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="text" placeholder="Subject" class="form-control">

                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <textarea placeholder="Subject" class="form-control"></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="subnit" value="SEND MESSAGE" class="loginBtn">
                                    </div>




                                </div>
                            </div>
                            <div class="col-lg-3  align-self-end text-center">

                                <img src="img/changePswdright.png" class="img-fluid mt-auto" alt="">
                            </div>
                        </div>
                        <img src="img/logoMedium.png" alt="" class="logo">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
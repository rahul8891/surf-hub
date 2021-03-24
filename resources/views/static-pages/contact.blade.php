@extends('layouts.static_pages')
@section('content')
<div class="feedHubNav followRequestLinksWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <ul class="mb-0 pl-0">
                    <li class="hover-no">
                        <a href="javascript:void(0);">Contact Us</a>
                    </li>
                    <li class="backBtn pull-right">
                        <a href="javascript: history.go(-1)"><img src="img/backBtnIcon.png" alt="" class="pr-2">Back</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible" role="alert" id="msg">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ ucfirst($message) }}
</div>
@elseif ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible" role="alert" id="msg">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ ucfirst($message) }}
</div>
@endif

<section class="loginWrap changePswd">
    <div class="innerWrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="formWrap">
                        <div class="row">
                            <div class="col-lg-9">
                                <h2>Contact Us</h2>
                                <p>Submit your detail here with message, We will consider your query shortly</p>
                                <form class="form" role="form" id="contact_us" name="contact_us" method="get" action="{{ route('getQuery') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="text" name="name" placeholder="Name" class="form-control" minlength="5" value="{{ old('name') }}" autocomplete="name" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="text" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}" autocomplete="email" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <input type="text" name="subject" placeholder="Subject" class="form-control">
                                            @error('subject')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group pos-rel">
                                        <div class="inputWrap">
                                            <textarea name="description" placeholder="Description" class="form-control"></textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="SEND MESSAGE" class="loginBtn">
                                    </div>
                                </form>
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
@extends('layouts.user.user')
@section('content')
<div class="feedHubNav ">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <ul class="mb-0 pl-0">
                    <li class="hover-no">
                        <a href="javascript:void(0);">Change Password</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section class="loginWrap changePswd">
    <div class="innerWrap">
        <div class="container">
            <div class="formWrap">
                <div class="row">
                    <div class="col-lg-4  align-self-center text-center">
                        <img src="{{ asset("/img/changePswd-left.png")}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-4">
                        <form method="POST" action="{{ route('updatePassword') }}">
                            @csrf
                            <div class="form">
                                <div class="text-center form-group">
                                    <img src="{{ asset("/img/logoMedium.png")}}" alt="">
                                </div>
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">
                                    {{ ucfirst($error) }}
                                </li>
                                @endforeach
                                @if($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <strong>Success!</strong> Your password has been successfully updated.
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                                <!-- <p class="text-success">{{ ucfirst($message) }}</p> -->
                                @endif

                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input id="current_password" type="password" placeholder="Current Password"
                                            autocomplete="current-password" name="current_password"
                                            value="{{ old('current_password') }}" class="form-control " required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password" name="password" placeholder="New Password"
                                            class="form-control" required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password" placeholder="Confirm Password" class="form-control"
                                            name="password_confirmation" autocomplete="new-password" required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="loginBtn">CHANGE PASSWORD </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4  align-self-center text-center">
                        <img src="{{ asset("/img/changePswdright.png")}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
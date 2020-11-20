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
                        <form method="POST" name="update_password" action="{{ route('user-password.update') }}">
                            @csrf
                            @method('put')
                            <div class="form">
                                <div class="text-center form-group">
                                    <img src="{{ asset("/img/logoMedium.png")}}" alt="">
                                </div>
                                @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input id="current_password" type="password" placeholder="Current Password"
                                            autocomplete="current-password" id="current_password"
                                            name="current_password" wire:model.defer="state.current_password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                        @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password" name="password" placeholder="New Password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            wire:model.defer="state.password" required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                    </div>
                                </div>
                                <div class="form-group pos-rel">
                                    <div class="inputWrap">
                                        <input type="password" placeholder="Confirm Password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password_confirmation" id="password_confirmation"
                                            autocomplete="new-password" wire:model.defer="state.password_confirmation"
                                            required>
                                        <span><img src="{{ asset("/img/lock.png")}}" alt=""></span>
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
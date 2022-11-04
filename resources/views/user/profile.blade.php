@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
            <div class="middle-content" id="post-data">
                @include('layouts.user.content_menu')

                <div class="profile-photo-edit">
                    <div class="profile-pic">
                        @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}"
                             alt="">
                        @endif
                    </div>
                    <div class="name">
                        <p>{{__(ucwords($user->user_profiles->first_name .' '. $user->user_profiles->last_name))}}</p>
                        <p class="mb-0">Surfhub <span class="blue-txt">$2540</span> Earn</p>
                    </div>
                </div>
                <div class="edit-profile-box">
                    <a href="{{ url('user/edit-profile') }}" class="btn edit-btn"><img src="/img/new/edit.png" alt="edit">EDIT</a>
                    <table>
                        <tbody>
                            <tr>
                                <td>User Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_name)) }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_profiles->first_name)) }}</td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_profiles->last_name)) }}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                <td>{{ $countries[$user->user_profiles->country_id]->name }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{ $user->user_profiles->icc }} {{ $user->user_profiles->phone }}</td>
                            </tr>
                            <tr>
                                <td>Preferred Language</td>
                                <td>:</td>
                                <td>{{ $language[$user->user_profiles->language] }}</td>
                            </tr>
                            <tr>
                                <td>Account Type</td>
                                <td>:</td>
                                <td>{{ $accountType[$user->account_type] }}</td>
                            </tr>
                            <tr>
                                <td>Paypal </td>
                                <td>:</td>
                                <td>abc@gmail.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if (is_null($postsList))
                <div class="post alert text-center alert-dismissible py-5" role="alert">
                    {{ ucWords('no matches found') }}
                </div>
                @endif
                
                <div class="justify-content-center ajax-load" style="display:none;margin-left: 40%">
                    <img src="/images/spiner4.gif" alt="loading" height="90px;" width="170px;">
                </div>
            </div>

            <div class="right-advertisement">
                <img src="/img/new/advertisement1.png" alt="advertisement">
                <img src="/img/new/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>

@endsection
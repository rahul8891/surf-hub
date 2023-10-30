@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
            <div class="middle-content" id="post-data">

                <div class="profile-photo-edit">
                    <div class="profile-pic">
                        @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}"
                             alt="" class="rounded-circle">
                        @endif

                        @if(Auth::user()->id == 1)
                        <img src="/img/imgpsh_fullsize_anim.png" alt="" class="rounded-circle">
                        @endif
                    </div>
                    <div class="name">
                        <p>{{__(ucwords($user->user_profiles->first_name .' '. $user->user_profiles->last_name))}}</p>
                        <p class="mb-0">Surfhub <span class="blue-txt">$0</span> Earn</p>
                    </div>
                </div>
                <div class="edit-profile-box">
                    @if($user->user_type != 'ADMIN')
                    <a href="{{ url('user/edit-profile') }}" class="btn edit-btn"><img src="/img/new/edit.png" alt="edit" class="align-middle me-1"> <span class="align-middle">EDIT</span></a>
                    @endif
                    <table>
                        <tbody>
                            <tr>
                                <td class="font_bold">User Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_name)) }}</td>
                            </tr>
                            <tr>
                                <td class="font_bold">First Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_profiles->first_name)) }}</td>
                            </tr>
                            <tr>
                                <td class="font_bold">Last Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($user->user_profiles->last_name)) }}</td>
                            </tr>
                            <tr>
                                <td class="font_bold">Country</td>
                                <td>:</td>
                                <td>{{$country_name}}</td>
                            </tr>
                            <tr>
                                <td class="font_bold">Phone</td>
                                <td>:</td>
                                <td>{{ $user->user_profiles->icc }} {{ $user->user_profiles->phone }}</td>
                            </tr>
                            <!-- <tr>
                                <td class="font_bold">Preferred Language</td>
                                <td>:</td>
                                <td>
                                    @if($user->user_profiles->language)
                                    {{ $language[$user->user_profiles->language] }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr> -->
                            <tr>
                                <td class="font_bold">Account Type</td>
                                <td>:</td>
                                <td>{{ $accountType[$user->account_type] }}</td>
                            </tr>
                            <tr>
                                <td class="font_bold">Paypal </td>
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
@extends('layouts.admin.admin_layout')
@section('content')
<!-- Info boxes -->
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                <div class="inner-my-details">
                    <div class="my-profile text-center">
                        <div class="profile-pic">
                            <img src="img/profile-pic.png" alt="profile-pic">
                            <span class="notification">6</span>
                        </div>
                        <div class="my-name">John Ward</div>
                        <div class="my-comp">Surfhub <span class="blue-txt">$0</span> Earn</div>
                    </div>
                    <div class="profile-menu">
                        <div class="profile-row">
                            <a href="#">
                                <img src="/img/new/posts.png" alt="posts">
                                <span>Posts - <span class="blue-txt num">585</span></span>
                            </a>
                        </div>
                        <div class="profile-row">
                            <a href="#">
                                <img src="/img/new/upload.png" alt="Uploads">
                                <span>Uploads - <span class="blue-txt num">585</span></span>
                            </a>
                        </div>
                        <div class="profile-row">
                            <a href="#">
                                <img src="/img/new/comments.png" alt="Comments">
                                <span>Comments <span class="notification">6</span></span>
                            </a>
                        </div>
                        <div class="profile-row">
                            <a href="#">
                                <img src="/img/new/small-logo.png" alt="Surfer Requests">
                                <span>Surfer Requests <span class="notification">6</span></span>
                            </a>
                        </div>
                        <div class="profile-row">
                            <a href="#">
                                <img src="/img/new/flag.png" alt="Reports" class="mr-2">
                                <span>Reports <span class="notification">6</span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="middle-content">
                <div class="table-responsive">
                    <div class="table-strip-wrap">
                        <table class="table table-striped">
                            <caption>Dashboard</caption>
                            <tbody>
                                <tr>
                                    <td>Uploads</td>
                                    <td class="value-table-col">{{ _( number_format($uploads ?? 0) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Surf Resorts</td>
                                    <td class="value-table-col">{{ _( number_format($resort) ) }}</td>
                                </tr> 
                                <tr>
                                    <td>Surf Resorts Earn</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Posts</td>
                                    <td class="value-table-col">{{ _( number_format($totalPost) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Users</td>
                                    <td class="value-table-col">{{ _( number_format($totalUser['active']) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Active Photographers</td>
                                    <td class="value-table-col">{{ _( number_format($photographer) ) }}</td>
                                </tr>
                                <tr>
                                    <td>Advertising Revenue</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Photographers Earn</td>
                                    <td class="value-table-col">0</td>
                                </tr> 
                                <tr>
                                    <td>SurfersEarn</td>
                                    <td class="value-table-col">0</td>
                                </tr>
                                <tr>
                                    <td>Active Advertisers</td>
                                    <td class="value-table-col">{{ _( number_format($advertiser) ) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.row -->
@endsection
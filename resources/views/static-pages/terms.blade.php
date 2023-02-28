@extends('layouts.user.new_layout')
@section('content')
<div class="container home-section mt-3">
    <div class="home-row">
        <div class="middle-content feedHubNav">
            <h2 class="titleRow">{{ __($pages->title) }}</h2>
            <div class="followRequestMainWrap">
                <div class="requests">
                    <p>
                        {!! __($pages->body) !!}
                    </p>
                </div>
            </div>      
        </div>
        <div class="right-advertisement">
            <div class="adWrap">
                    <img src="img/add1.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection
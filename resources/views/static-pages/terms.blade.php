@extends('layouts.user.new_layout')
@section('content')
<div class="feedHubNav ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-0 pl-0">
                    <h2 class="hover-no">
                        <a href="javascript:void(0);">{{ __($pages->title) }}</a>
                    </h2>
                </div>
            </div>
        </div>

    </div>
</div>
<section class="followRequestMainWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="requests">
                    <p>
                        {!! __($pages->body) !!}
                    </p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="adWrap">
                    <img src="img/add1.png" alt="" class="img-fluid">
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
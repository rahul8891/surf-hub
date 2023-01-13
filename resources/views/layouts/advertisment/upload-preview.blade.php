@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">

    <div class="container">
        <div class="mb-4">
            <a href="#" class="back-btn">
                <a class="align-middle" href="{{ route('uploadAdvertisment', Crypt::encrypt($post_id)) }}">
                    <img src="/img/back-btn.png" alt="back" class="align-middle">

                    Edit Ads</a>
            </a>
        </div>
        <div class="middle-content">
            <form class="" id="my-great-dropzone" method="POST" name="storeAdvert" action="{{ route('publishAdvert') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="upload-wrap upload-preview">
                    <div class="upload-header">
                        <h2>Ads Preview</h2>

                    </div>
                    <div>

                        @if(!empty($advertPost['advert_img']))
                        <div class="newsFeedImgVideo">
                            <img src="{{ env('FILE_CLOUD_PATH').'images/'.Auth::user()->id.'/'.$advertPost['advert_img'] }}" alt="" class="w-100">
                        </div>
                        @else
                        <div class="newsFeedImgVideo">
                            <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js w-100">
                                <source src="{{ env('FILE_CLOUD_PATH').'videos/'.Auth::user()->id.'/'.$advertPost['advert_vid'] }}" >    
                            </video>
                        </div>
                        @endif

                    </div>

                    <div class="upload-body">
                        <div class="row m-0">
                            <div class="col-xl-6 p-0">
                                <div class="upload-header">
                                    <h2>Target Market</h2>
                                </div>
                                <div class="review-left-col">
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Profile Targeting</div>
                                            <div class="value-col">Profile</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Gender</div>
                                            <div class="value-col">{{ $gender_type[$advertPost['gender']] }}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">User Type</div>
                                            <div class="value-col">
                                                @if($advertPost['optional_user_type'] == 'USER')
                                                {{ 'Surfer' }}
                                                @elseif($advertPost['optional_user_type'] == 'PHOTOGRAPHER')
                                                {{ 'PHOTOGRAPHER' }}
                                                @elseif($advertPost['optional_user_type'] == 'SURFER CAMP')
                                                {{ 'Surf Resort' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Country </div>
                                            <div class="value-col">
                                                @foreach($countries as $key => $value)
                                                @if($value->id == $advertPost['optional_country_id'])
                                                {{ $value->name }}
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">State </div>
                                            <div class="value-col">
                                                @foreach($states as $key => $value)
                                                @if($value->id == $advertPost['optional_state_id'])
                                                {{ $value->name }}
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Postcode</div>
                                            <div class="value-col">{{$advertPost['optional_postcode']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Local Beach</div>
                                            <div class="value-col">{{$advertPost['optional_beach']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Preferred Board</div>
                                            <div class="value-col">{{ $customArray['board_type'][$advertPost['optional_board_type']] }}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Preferred Camera Brand</div>
                                            <div class="value-col">
                                                @if($advertPost['optional_camera_brand'] == 1)
                                                {{ 'One' }}
                                                @elseif($advertPost['optional_camera_brand'] == 2)
                                                {{ 'Two' }}
                                                @else
                                                {{ 'Three' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Surf Resort</div>
                                            <div class="value-col">
                                                @if($advertPost['optional_surf_resort'] == 1)
                                                {{ 'One' }}
                                                @elseif($advertPost['optional_surf_resort'] == 2)
                                                {{ 'Two' }}
                                                @else
                                                {{ 'Three' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 p-0">
                                <div class="upload-header">
                                    <h2>Search Based</h2>
                                </div>
                                <div class="review-right-col">
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">User Type</div>
                                            <div class="value-col">
                                                @if($advertPost['search_user_type'] == 'USER')
                                                {{ 'Surfer' }}
                                                @elseif($advertPost['search_user_type'] == 'PHOTOGRAPHER')
                                                {{ 'PHOTOGRAPHER' }}
                                                @elseif($advertPost['search_user_type'] == 'SURFER CAMP')
                                                {{ 'Surf Resort' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Country</div>
                                            <div class="value-col">
                                                @foreach($countries as $key => $value)
                                                @if($value->id == $advertPost['country_id'])
                                                {{ $value->name }}
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">State</div>
                                            <div class="value-col">
                                                @foreach($states as $key => $value)
                                                @if($value->id == $advertPost['state_id'])
                                                {{ $value->name }}
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Beach </div>
                                            <div class="value-col">{{$advertPost['local_beach']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Breaks </div>
                                            <div class="value-col">{{ $advertPost['local_break'] }}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Surfer</div>
                                            <div class="value-col">{{$advertPost['surfer']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Fin Set Up</div>
                                            <div class="value-col">{{ $customArray['fin_set_up'][$advertPost['fin_set_up']] }}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Board Type</div>
                                            <div class="value-col">{{ $customArray['board_type'][$advertPost['board_type']] }}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Surf Resort</div>
                                            <div class="value-col">
                                                @if($advertPost['search_surf_resort'] == 1)
                                                {{ 'One' }}
                                                @elseif($advertPost['search_surf_resort'] == 2)
                                                {{ 'Two' }}
                                                @else
                                                {{ 'Three' }}
                                                @endif 
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-xl-12 p-0">
                                <div class="upload-header">
                                    <h2>Campaingn Details</h2>
                                </div>
                                <div class="review-left-col">
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Currency type</div>
                                            <div class="value-col">
                                                @if($advertPost['currency_type'] == 1)
                                                {{ 'One' }}
                                                @elseif($advertPost['currency_type'] == 2)
                                                {{ 'Two' }}
                                                @else
                                                {{ 'Three' }}
                                                @endif 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Your Budget </div>
                                            <div class="value-col">{{$advertPost['your_budget']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">$ Per View</div>
                                            <div class="value-col">{{$advertPost['per_view']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">Start Date </div>
                                            <div class="value-col">{{$advertPost['start_date']}}</div>
                                        </div>
                                    </div>
                                    <div class="review-box">
                                        <div class="inner-review-box">
                                            <div class="label-col">End Date </div>
                                            <div class="value-col">{{$advertPost['end_date']}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <input type="hidden" name="post_id" id="post_id" value="{{ isset($post_id)?$post_id:'' }}">
                            <button class="btn blue-btn w-150" type="submit">PUBLISH ADS</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
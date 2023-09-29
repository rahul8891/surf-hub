@extends('layouts.user.new_layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />

<section class="home-section">

    <div class="container">
        <div class="home-row">
            <div class="middle-content">
            <form class="" id="storeAdvert" method="POST" name="storeAdvert" action="{{ route('storeAdvert') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
                <div class="upload-wrap">
                        <div class="upload-header">
                            <h2>Upload your ads</h2>
                        </div>
                        <div class="upload-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="multiple-photo-upload">
                                        <div class=" align-items-start d-flex flex-wrap gap-4">
                                            <div class="upload-photo-multiple">
                                                <div>
                                                    <img src="/img/blue-upload-large.png">
                                                    <span>Drag files to<br>upload</span>
                                                </div>
                                                <button class="blue-btn btn">CHOOSE FILE</button>
                                                <input type="file" id="input_multifile" name="files[]">
                                            </div>
                                            <div class="upload-file-name" id="filesInfo">
                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="row">
                                        <label class="col-lg-3">Add Link</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control ps-2" name="ad_link" value="{{ isset($advertPost['ad_link'])?$advertPost['ad_link']:'' }}">
                                            <small>Note :- If a user clicks on your ad they will
                                                be directed to this address</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-2">Campaign Name</label>
                                        <div class="col-md-5">
                                            <textarea class="form-control ps-2" placeholder="campaign name..." style="height: 80px" name="post_text">{{ isset($advertPost['post_text'])?$advertPost['post_text']:'' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="upload-header">
                            <h2>Target Market</h2>
                        </div>
                        <div class="upload-body">
                            <div class="row">
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-9">
                                    <ul class="target-market">
                                        <div class="form-check mb-3">
                                            <input type="radio" id="surfHub" name="surfHub" class="form-check-input" value="1" {{ ( isset($advertPost['surfhub_target']) && $advertPost['surfhub_target'] == 1)?'checked':'' }} >
                                            <h6 class="d-inline-block">SurfHub</h5>
                                                <label for="surfHub">By selecting this type of
                                                    targeting your Ad will be placed in the Main SurfHub Feed which is
                                                    the Home Page of the
                                                    SurfHub site prior to anyone logging in. Essentially you are
                                                    targeting the types of people that view our site but nothing more
                                                    specific than that.</label>

                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="radio" id="profile" name="profile" class="form-check-input" value="1" {{ ( isset($advertPost['profile_target']) && $advertPost['profile_target'] == 1)?'checked':'' }}>
                                            <h6 class="d-inline-block">Profile Targeting</h5>
                                                <label for="profile">By selecting this type of targeting your Ad will
                                                    only be viewed by users that match the specific profile that you
                                                    create e.g. you select "Male" for gender only male SurfHub Users
                                                    will view your Ad. The available “Profile” fields will appear below
                                                    if you choose this targeting option.
                                                    Note: by using Profile Targeting your Ad will appear on a
                                                    combination of MyFeed, MyHub and Search pages. Basically whichever
                                                    page will allow
                                                    your Ad to be at the highest display point.</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="radio" idr="search" name="search" class="form-check-input" value="1" {{ ( isset($advertPost['search_target']) && $advertPost['search_target'] == 1)?'checked':'' }}>
                                            <h6 class="d-inline-block">Search Based Targeting</h5>
                                                <label for="search">By selecting this type of targeting your Ad will
                                                    only be viewed when Users run a
                                                    search that matches your choices below e.g. if you select Manly
                                                    Beach only users that search for footage from Manly Beach will view
                                                    your Ad. Note that this type
                                                    of targeting can be used in conjunction with Profile Targeting e.g.
                                                    you could have your Ad viewed by “Male” users that search
                                                    “Manly Beach”. Note that these Ads
                                                    will only appear in the “Search” pages.</label>
                                        </div>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="upload-header">
                            <h2>Optional Info</h2>
                        </div>
                        <div class="upload-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-2">Gender</label>
                                        <div class="col-md-8">
                                            <div class="row">
                                                @foreach($gender_type as $key => $value)
                                                <div class="col-sm-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="gender" id="{{$key}}" value="{{$key}}"  {{ ( isset($advertPost['gender']) && $advertPost['gender'] == $key)?'checked':'' }}>
                                                        <label class="form-check-label" for="{{$key}}">
                                                            {{$value}}
                                                        </label>
                                                    </div>

                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-2">User Type</label>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-sm-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="userType" id="surfer" value="USER"  {{ ( isset($advertPost['optional_user_type']) && $advertPost['optional_user_type'] == 'USER')?'checked':'' }}>
                                                        <label class="form-check-label" for="surfer">
                                                            surfer
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="userType" id="photographer" value="PHOTOGRAPHER"  {{ ( isset($advertPost['optional_user_type']) && $advertPost['optional_user_type'] == 'PHOTOGRAPHER')?'checked':'' }}>
                                                        <label class="form-check-label" for="photographer">
                                                            Photographer
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="userType" id="surfResort" value="SURFER CAMP"  {{ ( isset($advertPost['optional_user_type']) && $advertPost['optional_user_type'] == 'SURFER CAMP')?'checked':'' }}>
                                                        <label class="form-check-label" for="surfResort">
                                                            Surf Resort
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Country</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="country_id" id="country_id">
                                                <option value="">Country</option>
                                                @foreach($countries as $key => $value)
                                                <option value="{{ $value->id }}" {{ ( isset($advertPost['optional_country_id']) && $advertPost['optional_country_id'] == $value->id )?'selected':'' }} >{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">State</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="state_id" id="state_id">
                                                <option value="">State</option>
                                                @foreach($states as $key => $value)
                                                <option value="{{ $value->id }}" {{ ( isset($advertPost['optional_state_id']) && $advertPost['optional_state_id'] == $value->id )?'selected':'' }} >{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Postcode</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control ps-2 mb-0" name="postcode" value="{{ isset($advertPost['optional_postcode'])?$advertPost['optional_postcode']:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Local Beach</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control ps-2 mb-0 ad-search-box" name="local_beach_break" autocomplete="off" value="{{ isset($advertPost['optional_beach'])?$advertPost['optional_beach']:''}}">
                                            <input type="hidden" name="local_beach_id"
                                                   id="local_beach_id" class="form-control" value="{{ isset($advertPost['optional_beach_id'])?$advertPost['optional_beach_id']:'' }}">
                                            <div class="auto-search" id="beach_list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Preferred Borad</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" id="board_type" name="board_type">
                                                <option value="">--Select--</option>
                                                 @foreach($customArray['board_type'] as $key => $value)
                                                <option value="{{ $key }}" {{ ( isset($advertPost['optional_board_type']) && $advertPost['optional_board_type'] == $key)?'selected':'' }}>{{ $value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Preferred Camera Brand</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="camera_brand">
                                                <option value="">--Select--</option>
                                                <option value="1" {{ ( isset($advertPost['optional_camera_brand']) && $advertPost['optional_camera_brand'] == 1)?'selected':'' }}>One</option>
                                                <option value="2" {{ ( isset($advertPost['optional_camera_brand']) && $advertPost['optional_camera_brand'] == 2)?'selected':'' }}>Two</option>
                                                <option value="3" {{ ( isset($advertPost['optional_camera_brand']) && $advertPost['optional_camera_brand'] == 3)?'selected':'' }}>Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Surf Resort</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="resort">
                                                <option value="">--Select--</option>
                                                <option value="1" {{ ( isset($advertPost['optional_surf_resort']) && $advertPost['optional_surf_resort'] == 1)?'selected':'' }}>One</option>
                                                <option value="2" {{ ( isset($advertPost['optional_surf_resort']) && $advertPost['optional_surf_resort'] == 2)?'selected':'' }}>Two</option>
                                                <option value="3" {{ ( isset($advertPost['optional_surf_resort']) && $advertPost['optional_surf_resort'] == 3)?'selected':'' }}>Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="upload-header">
                            <h2>Search Criteria </h2>
                        </div>
                        <div class="upload-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">User Type</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="search_user_type">
                                                <option value=""></option>
                                                <option value="USER" {{ ( isset($advertPost['search_user_type']) && $advertPost['search_user_type']  == 'USER')?'selected':'' }}>Surfer</option>
                                                <option value="PHOTOGRAPHER" {{ ( isset($advertPost['search_user_type']) && $advertPost['search_user_type'] == 'PHOTOGRAPHER')?'selected':'' }}>Photographer</option>
                                                <option value="SURFER CAMP" {{ ( isset($advertPost['search_user_type']) && $advertPost['search_user_type'] == 'SURFER CAMP')?'selected':'' }}>Surf Resort</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Country</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="search_country_id" id="search_country_id">
                                                <option value="">Country</option>
                                                @foreach($countries as $key => $value)
                                                <option value="{{ $value->id }}" {{ ( isset($advertPost['country_id']) && $advertPost['country_id'] == $value->id )?'selected':'' }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">State</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="search_state_id" id="search_state_id">
                                                <option value="">State</option>
                                                @foreach($states as $key => $value)
                                                <option value="{{ $value->id }}" {{ ( isset($advertPost['state_id']) && $advertPost['state_id'] == $value->id )?'selected':'' }}>{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Beach</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{ isset($advertPost['local_beach'])?$advertPost['local_beach']:''}}"
                                                  class="form-control ps-2 mb-0 search-box" name="local_beach_break" autocomplete="off" required>
                                            <input type="hidden" name="local_beach_break_id"
                                                   id="local_beach_break_id" class="form-control" value="{{ isset($advertPost['local_beach_id'])?$advertPost['local_beach_id']:''}}">
                                            <div class="auto-search search1" id="country_list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Breaks</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="break_id" id="break_id">
                                                <option value="">-- Break --</option>
                                                @if($breaks)
                                                @foreach($breaks as $key => $value)
                                                <option value="{{ $value->id }}"
                                                {{ (isset($advertPost['local_break_id']) && ($advertPost['local_break_id'] == $value->id)) ? "selected" : "" }}>
                                            {{ $value->break_name }}</option>
                                        @endforeach
                                        @endif
                                         </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Surfer</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{isset($advertPost['surfer'])?$advertPost['surfer']:''}}" name="other_surfer"
                                               class="form-control ps-2 mb-0 other_surfer" placeholder="" >
                                        <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id"
                                               id="surfer_id" class="form-control surfer_id">
                                        <div class="auto-search search2" id="other_surfer_list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Fin Set Up</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="fin_set_up">
                                                <option value="">--Select--</option>
                                                @foreach($customArray['fin_set_up'] as $key => $value)
                                                <option value="{{ $key }}" {{ ( isset($advertPost['fin_set_up']) && $advertPost['fin_set_up'] == $key)?'selected':'' }}>{{ $value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Board Type</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" id="search_board_type" name="search_board_type">
                                                <option value="">--Select--</option>
                                                 @foreach($customArray['board_type'] as $key => $value)
                                                <option value="{{ $key }}" {{ ( isset($advertPost['board_type']) && $advertPost['board_type'] == $key)?'selected':'' }}>{{ $value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Surf Resort</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="search_resort">
                                                <option value=""></option>
                                                <option value="1" {{ ( isset($advertPost['search_surf_resort']) && $advertPost['search_surf_resort'] == 1)?'selected':'' }}>One</option>
                                                <option value="2" {{ ( isset($advertPost['search_surf_resort']) && $advertPost['search_surf_resort'] == 2)?'selected':'' }}>Two</option>
                                                <option value="3" {{ ( isset($advertPost['search_surf_resort']) && $advertPost['search_surf_resort'] == 3)?'selected':'' }}>Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="upload-header">
                            <h2>Campaingn Details</h2>
                        </div>
                        <div class="upload-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Currency type</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="currency_type">
                                                <option value=""></option>
                                                <option value="1" {{ ( isset($advertPost['currency_type']) && $advertPost['currency_type'] == 1)?'selected':'' }}>One</option>
                                                <option value="2" {{ ( isset($advertPost['currency_type']) && $advertPost['currency_type'] == 2)?'selected':'' }}>Two</option>
                                                <option value="3" {{ ( isset($advertPost['currency_type']) && $advertPost['currency_type'] == 3)?'selected':'' }}>Three</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Your Budget </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control ps-2 mb-0" name="budget" value="{{ isset($advertPost['your_budget'])?$advertPost['your_budget']:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">$ Per View</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control ps-2 mb-0" name="per_view" value="{{ isset($advertPost['per_view'])?$advertPost['per_view']:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">Start Date</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control ps-2 mb-0" name="start_date" value="{{ isset($advertPost['start_date'])?$advertPost['start_date']:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3 align-items-center">
                                        <label class="col-md-4">End Date</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control ps-2 mb-0" name="end_date" value="{{ isset($advertPost['end_date'])?$advertPost['end_date']:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-10">
                                <button class="btn blue-btn w-150" type="submit">CREATE ADS</button>
                                <input type="hidden" name="preview" id="preview" value="">
                                <input type="hidden" name="post_id" id="post_id" value="{{ isset($post_id)?$post_id:'' }}">
                                <!--<a class="blue-txt previewAds">Preview your Ads</a>-->
                                <button class="blue-txt previewAds" type="submit">Preview your Ads</button>
                                
                            </div>
                        </div>
                    </div>
            </form>
            </div>

        </div>
    </div>
</section>
@endsection
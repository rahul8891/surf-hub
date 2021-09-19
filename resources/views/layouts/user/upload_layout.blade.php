<style>
    .rating-box {
        height: 80px;
    }
    .rating-box ul {
        text-decoration: none;
        list-style: none;
    }
</style>
<div class="post p-0 ">
    <div class="uploadWrap a_uploadWrap">
        <div class="head">
            <div class="row">
                @if(Auth::user() && (!str_contains(Request::path(),'search')))
                <div class="col-md-6">
                    <img src="{{ asset("/img/upload.png")}}" alt=""> Upload Video/Photo
                </div>
                @endif
                @if((str_contains(Request::path(),'myhub') || str_contains(Request::path(),'search')))
                <div class="col-md-3 col-6">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/sort.png")}}" alt=""> Sort
                        </button>
                        
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'dateDesc']) }}">Post Date (New to Old)</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'dateAsc']) }}">Post Date (Old to New)</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'surfDateDesc']) }}">Surf Date (New to Old)</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'surfDateAsc']) }}">Surf Date (Old to New)</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'beach']) }}">Beach / Break</a>
                            <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'star']) }}">Star Rating </a>
                        </div>                        
                    </div>
                </div>
                <div class="col-md-3 col-6 text-web-right">
                    <div class="dropdown" id="dropdown-toggle-id">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="modal" data-target="#filterModal">
                            <img src="{{ asset("/img/filter.png")}}" alt=""> Filter
                        </button>

                        <!-- modal -->
                        <div class="modal fade filterModal uploadModal " id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"
                                            onclick="this.form.reset();">
                                        <img alt="" src="{{ asset("/img/close.png")}}">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if(str_contains(Request::path(),'search'))
                                    <form class="filterWrap" action="{{route('searchPosts')}}" aria-labelledby="dropdownMenuButton2">
                                    @endif
                                    
                                    @if(str_contains(Request::path(),'myhub'))
                                    <form class="filterWrap" action="{{ route('myhub') }}" aria-labelledby="dropdownMenuButton2">
                                    @endif
                                    
                                    <div class="filterHeader">
                                        <div class="heading">
                                            <img src="{{ asset("/img/logo_small.png")}}" alt="">
                                            <h2>Filter</h2>
                                        </div>
                                        <input type="reset" value="Clear" id="clear" class="ml-auto float-right close" >
                                    </div>
                                    <div class="filterBody">
                                        @if(Auth::user())
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <label class="mb-0">Surfer</label>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-3 col-6">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="radio" id="test-me" name="filterUser" value="me" {{ Request::get('me') ? "checked" : "" }} />
                                                            <label for="test-me" class="pr-4">Me</label>
                                                        </div>
                                    
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-6">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="radio" id="test-other" name="filterUser" value="others" {{ Request::get('others') ? "checked" : "" }} />
                                                            <label for="test-other" class="pr-4">Other</label>
                                                        </div>
                                    
                                                    </div>
                                                    <div class="col-md-5 col-sm-5 col-6">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="radio" id="test-unknown" name="filterUser" value="unknown" {{ Request::get('unknown') ? "checked" : "" }} />
                                                            <label for="test-unknown" class="pr-4">Unknown</label>
                                                        </div>
                                    
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-sm-4 float-right" style="display:none" id="othersFilterSurfer">
                                                    <div class="selectWrap pos-rel">
                                                        <div class="selectWrap pos-rel">
                                                            <input type="text" value="{{ old('other_surfer')}}" name="other_surfer" placeholder="Search other user" class="form-control filter_other_surfer" />
                                                                <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id" id="surfer_id_filter" class="form-control surfer_id" />
                                                            <div class="auto-search search2" id="filter_other_surfer_list"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- row start -->
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-7">
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">Start Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <input class="form-control" type="date" name="surf_date" id="datepicker"
                                                                value="{{ Request::get('surf_date') ? Request::get('surf_date') : "" }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">End Date</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <input class="form-control" type="date" name="end_date" id="datepicker"
                                                            value="{{ Request::get('end_date') ? Request::get('end_date') : "" }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">Country</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <select class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                                            name="country_id" id="filter_country_id">
                                                                <option value="">-- Country --</option>
                                                                @foreach($countries as $key => $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ old('country_id',Request::get('country_id')) == $value->id ? "selected" : "" }}>
                                                                    {{ $value->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span>
                                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">State</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <select class="form-control" name="state_id" id="filter_state_id">
                                                                <option selected="selected" value="">-- State --</option>
                                                                @foreach($states as $key => $value)
                                                                <option value="{{ $value->id }}" 
                                                                    {{ old('state_id',Request::get('state_id')) == $value->id ? "selected" : "" }}>
                                                                    {{ $value->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span>
                                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0 width-95">Beach / Break </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="pos-rel">
                                                            <input type="text" value="{{ old('local_beach_break',$beach_name)}}"
                                                                placeholder="Search Beach Break" class="form-control search-box2">
                                                            <input type="hidden" value="{{ Request::get('local_beach_break_id') ? Request::get('local_beach_break_id') : "" }}" name="local_beach_break_id"
                                                                id="local_beach_break_id2" class="form-control">
                                                            <div class="auto-search searchTwo" id="country_list2"></div>                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">Wave size </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <select class="form-control" name="wave_size">  
                                                                <option value="">{{ __('-- Select --')}}</option>
                                                                @foreach($customArray['wave_size'] as $key => $value)
                                                                <option value="{{ $key }}" {{ old('wave_size',Request::get('wave_size')) == $key ? "selected" : "" }}>{{ $value}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <span>
                                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">Board Type </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="selectWrap pos-rel">
                                                            <select class="form-control" name="board_type">
                                                                <option value="">{{ __('-- Select --')}}</option>
                                                                @foreach($customArray['board_type'] as $key => $value)
                                                                <option value="{{ $key }}" {{ old('board_type',Request::get('board_type')) == $key ? "selected" : "" }}>{{ $value}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <span>
                                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                    
                                                <div class="row mb-3 rating-box">
                                                    <div class="col-md-4">
                                                        <label class="mb-0">Star Rating </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <ul class="pl-0 mb-0 ">                                                
                                                            <li>
                                                                <input id="filter-rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="1" data-size="xs" value="0" />
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test3" {{ Request::get('FLOATER') ? "checked" : "" }} name="FLOATER"/>
                                                            <label for="test3" class="width-138">Floater</label>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test4" {{ Request::get('AIR') ? "checked" : "" }} name="AIR"/>
                                                            <label for="test4" class="width-138">Air</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test5" {{ Request::get('360') ? "checked" : "" }} name="360"/>
                                                            <label for="test5" class="width-138">360</label>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test6" {{ Request::get('DROP_IN') ? "checked" : "" }} name="DROP_IN"/>
                                                            <label for="test6" class="width-138">Drop In</label>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test7" {{ Request::get('BARREL_ROLL') ? "checked" : "" }} name="BARREL_ROLL"/>
                                                            <label for="test7" class="width-138">Barrel Roll</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test8" {{ Request::get('WIPEOUT') ? "checked" : "" }} name="WIPEOUT" />
                                                            <label for="test8" class="width-138">Wipeout</label>
                                                        </div>
                                                    </div>
                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test9" {{ Request::get('CUTBACK') ? "checked" : "" }} name="CUTBACK" />
                                                            <label for="test9" class="width-138">Cutback </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12 col-6 mb-3">
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="test10" {{ Request::get('SNAP') ? "checked" : "" }} name="SNAP"/>
                                                            <label for="test10" class="width-138">Snap </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- row ends -->
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button class="applyBtn">apply filter</button>
                                            </div>
                                        </div>
                                        <img src="{{ asset("/img/filterLeftIcon.png")}}" alt="" class="leftImg">
                                        <img src="{{ asset("/img/filterRightIcon.jpg")}}" alt="" class="rightImg">
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- modal -->
                    </div>
                </div>
                @endif

            </div>
        </div>
        @if(Auth::user() && (!str_contains(Request::path(),'search')))
        <div class="post-head">
            <a href="#" data-toggle="modal" data-target="#exampleModal" data-backdrop="static" data-keyboard="false">
                <div class="userDetail">

                    @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" class="profileImg" alt="">
                    @else
                    <div class="profileImg no-image">
                        {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}{{ucwords(substr(Auth::user()->user_profiles->last_name,0,1))}}
                    </div>
                    @endif
                    <div class="pl-3">
                        <h4>Upload your latest Photo/Video</h4>
                    </div>
                </div>
            </a>
        </div>
        @endif
    </div>
</div>
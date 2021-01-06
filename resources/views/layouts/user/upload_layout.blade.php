<div class="post p-0 ">
    <div class="uploadWrap">
        <div class="head">
            <div class="row">
                @if(Auth::user() && (!str_contains(Request::path(),'search')))
                <div class="col-md-6">
                    <img src="{{ asset("/img/upload.png")}}" alt=""> Upload Video/Photo
                </div>
                @else
                <div class="col-md-6">
                    <img src="{{ asset("/img/phone1.png")}}" alt=""> Search Video/Photo
                </div>
                @endif
                @if(Auth::user() && (str_contains(Request::path(),'myhub') || str_contains(Request::path(),'search')))
                <div class="col-md-3 col-6">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/sort.png")}}" alt=""> Sort
                        </button>
                        @if(str_contains(Request::path(),'search'))
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="{{route('searchPosts',['sort'=>'dateDesc'])}}">Date (New to Old)</a>
                            <a class="dropdown-item" href="{{route('searchPosts',['sort'=>'dateAsc'])}}">Date (Old to New)</a>
                            <a class="dropdown-item" href="{{route('searchPosts',['sort'=>'beach'])}}">Beach / Break</a>
                            <a class="dropdown-item" href="{{route('searchPosts',['sort'=>'star'])}}">Star Rating </a>
                        </div>
                        @endif

                        @if(str_contains(Request::path(),'myhub'))
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'dateDesc'])}}">Date (New to Old)</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'dateAsc'])}}">Date (Old to New)</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'beach'])}}">Beach / Break</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'star'])}}">Star Rating </a>
                        </div>
                        @endif
                        
                    </div>
                </div>
                <div class="col-md-3 col-6 text-web-right">
                    <div class="dropdown" id="dropdown-toggle-id">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/filter.png")}}" alt=""> Filter
                        </button>


                        @if(str_contains(Request::path(),'search'))
                            <form class="dropdown-menu filterWrap" action="{{route('searchFilterIndex')}}" aria-labelledby="dropdownMenuButton2">
                        @endif

                        @if(str_contains(Request::path(),'myhub'))
                            <form class="dropdown-menu filterWrap" action="{{route('myhubFilterIndex')}}" aria-labelledby="dropdownMenuButton2">
                        @endif

                            <div class="filterHeader">
                                <div class="heading">
                                    <img src="{{ asset("/img/logo_small.png")}}" alt="">
                                    <h2>Filter</h2>
                                </div>
                                <input type="reset" value="Clear" id="clear" class="ml-auto float-right close" >
                            </div>
                            <div class="filterBody">
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Surfer</label>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="row">
                                            <div class="col-md-4 col-4">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="test-me" name="Me" />
                                                    <label for="test-me" class="pr-4">Me</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="test-other" name="Others" />
                                                    <label for="test-other" class="pr-4">Other</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="test-unknown" name="Unknown" />
                                                    <label for="test-unknown" class="pr-4">Unknown</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Start Date</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <input class="form-control" type="date" name="surf_date" id="startDatepicker"
                                                value="{{ old('surf_date') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test3" name="FLOATER"/>
                                            <label for="test3" class="width-138">Floater</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">End Date</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <input class="form-control" type="date" name="end_date" id="endDatepicker2"
                                            value="{{ old('surf_date') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test4" name="AIR"/>
                                            <label for="test4" class="width-138">Air</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Country</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <select class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                            name="country_id" id="filter_country_id">
                                            <option value="">-- Country --</option>
                                            @foreach($countries as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('country_id',$userDetail->country_id) == $value->id ? "selected" : "" }}>
                                                {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test5" name="360"/>
                                            <label for="test5" class="width-138">360</label>
                                        </div>

                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">State</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <select class="form-control" name="state_id" id="filter_state_id">
                                                <option selected="selected" value="">-- State --</option>
                                                @foreach($states as $key => $value)
                                                <option value="{{ $value->id }}" 
                                                    {{ old('state_id',$userDetail->state_id) == $value->id ? "selected" : "" }}>
                                                    {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test6" name="DROP_IN"/>
                                            <label for="test6" class="width-138">Drop In</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0 width-95">Beach / Break </label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            @php
                                            $bb=$userDetail->beach_breaks;
                                            $beach_break = $bb->beach_name.','.$bb->break_name
                                            .''.$bb->city_region.','.$bb->state.','.$bb->country;
                                            @endphp
                                            <input type="text" value="{{ old('local_beach_break',$beach_break)}}"
                                                placeholder="Search Beach Break" class="form-control search-box2">
                                            <input type="hidden" value="{{ old('local_beach_break_id',$userDetail->local_beach_break_id)}}" name="local_beach_break_id"
                                                id="local_beach_break_id2" class="form-control">
                                            <div class="auto-search searchTwo" id="country_list2"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test7" name="BARREL_ROLL"/>
                                            <label for="test7" class="width-138">Barrel Roll</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Wave size </label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <select class="form-control" name="wave_size">
                                                <option value="">{{ __('-- Select --')}}</option>
                                                @foreach($customArray['wave_size'] as $key => $value)
                                                <option value="{{ $key }}" {{ old('wave_size') == $key ? "selected" : "" }}>{{ $value}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test8" name="WIPEOUT" />

                                            <label for="test8" class="width-138">Wipeout</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Board Type </label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <select class="form-control" name="board_type">
                                                <option value="">{{ __('-- Select --')}}</option>
                                                @foreach($customArray['board_type'] as $key => $value)
                                                <option value="{{ $key }}" {{ old('board_type') == $key ? "selected" : "" }}>{{ $value}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test9" name="CUTBACK" />
                                            <label for="test9" class="width-138">Cutback </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Rating</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <div class="rate">
                                                <ul class="mb-0 pl-0">
                                                    <li>
                                                        <label>Star Rating</label>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><img src="{{ asset("/img/star-grey.png")}}" alt=""></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test10" name="SNAP"/>
                                            <label for="test10" class="width-138">Snap </label>
                                        </div>

                                    </div>
                                </div>
                               
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
                        {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}
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
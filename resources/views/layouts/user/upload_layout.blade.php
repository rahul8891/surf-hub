<div class="post p-0 ">
    <div class="uploadWrap">
        <div class="head">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset("/img/upload.png")}}" alt=""> Upload Video/Photo
                </div>
                @if(Auth::user() && (Request::path() == 'user/myhub' || Request::path() == 'user/myhub/filter'))
                <div class="col-md-3 col-6">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/sort.png")}}" alt=""> Sort
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'dateDesc'])}}">Date (New to Old)</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'dateAsc'])}}">Date (Old to New)</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'beach'])}}">Beach / Break</a>
                            <a class="dropdown-item" href="{{route('myhub',['sort'=>'star'])}}">Star Rating </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-web-right">
                    <div class="dropdown" id="dropdown-toggle-id">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/filter.png")}}" alt=""> Filter
                        </button>


                        <form class="dropdown-menu filterWrap" action="{{route('filterIndex')}}" aria-labelledby="dropdownMenuButton2">



                            <div class="filterHeader">
                                <div class="heading">
                                    <img src="{{ asset("/img/logo_small.png")}}" alt="">
                                    <h2>Filter</h2>
                                </div>
                                <a href="#" class="ml-auto close" id="close" data-toggle="dropdown">Clear</a>
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
                                                    <input type="checkbox" id="Me" name="Me" />
                                                    <label for="Me" class="pr-4">Me</label>

                                                </div>

                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="Other" name="Others" />
                                                    <label for="Other" class="pr-4">Other</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 col-4">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="Unknown" name="Unknown" />
                                                    <label for="Unknown" class="pr-4">Unknown</label>
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
                                            <input class="form-control" type="date" name="surf_date" id="datepicker"
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
                                            <input class="form-control" type="date" name="end_date" id="datepicker"
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
                                            name="country_id" id="country_id">
                                            <option value="">-- Country --</option>
                                            @foreach($countries as $key => $value)
                                            <option value="{{ $value->id }}"
                                                {{ old('country_id') == $value->id ? "selected" : "" }}>
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
                                            <select class="form-control" name="state_id" id="state_id">
                                                <option selected="selected" value="">-- State --</option>
                                                @foreach($states as $key => $value)
                                                <option value="{{ $value->id }}" {{ old('state_id') == $value->id ? "selected" : "" }}>
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
                                            <input type="text" value="{{ old('local_beach_break')}}"
                                placeholder="Search Beach Break" class="form-control search-box">
                            <input type="hidden" value="{{ old('local_beach_break_id')}}" name="local_beach_break_id"
                                id="local_beach_break_id" class="form-control">
                            <div class="auto-search search1" id="country_list"></div>
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
<<<<<<< HEAD
                                            <input type="checkbox" id="test8" name="WIPEOUT" />
=======
                                            <input type="checkbox" id="test8" />
>>>>>>> shubham_dev_1_bug
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
<<<<<<< HEAD
                                            <input type="checkbox" id="test9" name="CUTBACK" />
=======
                                            <input type="checkbox" id="test9" />
>>>>>>> shubham_dev_1_bug
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
                                            <div class="rating">
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
    </div>
</div>
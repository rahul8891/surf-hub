<div class="post p-0 ">
    <div class="uploadWrap">
        <div class="head">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset("/img/upload.png")}}" alt=""> Upload Video/Photo
                </div>
                @if(Auth::user() && Request::path() == 'user/myhub')
                <div class="col-md-3 col-6">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/sort.png")}}" alt=""> Sort
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="#">Date (New to Old)</a>
                            <a class="dropdown-item" href="#">Date (Old to New)</a>
                            <a class="dropdown-item" href="#">Beach / Break</a>
                            <a href="#" class="dropdown-item">Star Rating </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 text-web-right">
                    <div class="dropdown" id="dropdown-toggle-id">

                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2"
                            data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset("/img/filter.png")}}" alt=""> Filter
                        </button>

                        <form class="dropdown-menu filterWrap" aria-labelledby="dropdownMenuButton2">
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
                                            <div class="col-md-6 col-6">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="test1" />
                                                    <label for="test1" class="pr-4">Me</label>

                                                </div>

                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="cstm-check pos-rel">
                                                    <input type="checkbox" id="test2" />
                                                    <label for="test2" class="pr-4">Other</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <input type="text" class="form-control">
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <label class="mb-0">Start Date</label>
                                    </div>
                                    <div class="col-md-5 col-sm-7">
                                        <div class="selectWrap pos-rel">
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test3" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test4" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test5" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test6" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test7" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test8" />
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
                                            <select class="form-control">
                                                <option>
                                                </option>
                                            </select>
                                            <span>
                                                <img src="{{ asset("/img/select-downArrow.png")}}" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test9" />
                                            <label for="test9" class="width-138">Cutback </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-5 ">

                                    </div>
                                    <div class="col-md-5">
                                        <div class="cstm-check pos-rel">
                                            <input type="checkbox" id="test10" />
                                            <label for="test10" class="width-138">Snap </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-2">

                                    </div>
                                    <div class="col-md-5">

                                    </div>
                                    <div class="col-md-5">
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
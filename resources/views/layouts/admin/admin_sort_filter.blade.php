<div class="filter-sort">

    <div class="sort dropdown">
        <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/img/sort.png" alt="filter">
            <span>Sort</span>
        </button>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'dateDesc']) }}">Post Date (New to Old)</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'dateAsc']) }}">Post Date (Old to New)</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'surfDateDesc']) }}">Surf Date (New to Old)</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'surfDateAsc']) }}">Surf Date (Old to New)</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'beach']) }}">Beach / Break</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort'=>'star']) }}">Star Rating </a></li>
        </ul>
    </div>

    <div class="filter dropdown">
        <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
            <img src="/img/filter.png" alt="filter">
            <span>Filter</span>
        </button>
        <div class="dropdown-menu dropdownmenuname">
            @if(str_contains(Request::path(),'search') || str_contains(Request::path(),''))
            <form class="filterWrap" action="{{route('adminSearchPosts')}}" aria-labelledby="dropdownMenuButton2" name="searchFilter">
                @endif
                
                    @if(str_contains(Request::path(),'myhub'))
                    <form class="filterWrap" action="{{ route('adminMyHub') }}" aria-labelledby="dropdownMenuButton2">
                        @endif
                        <div class="filter-header">
                            <div class="col-md-9">
                                <h5>Filter</h5>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="close" data-dismiss="modal" aria-label="Close"
                                        onclick="this.form.reset();"> Clear

                                </button>
                            </div>
                            <!--<a href="javascript:void(0)" onclick="this.form.reset();">Clear</a>-->
                        </div>
                        <div class="filter-body">
                            @if(Auth::user())
<!--                            <div class="row align-items-center mb-4 justify-content-between">
                                <div class="col-md-7">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <label for="surfe" class="form-label">Surfer</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-inline-block form-check mb-0 me-3">
                                                <input type="checkbox" class="form-check-input mt-0"
                                                       id="me-surfe" name="filterUser" value="me">
                                                <label class="form-check-label" for="me-surfe">Me</label>
                                            </div>
                                            <div class="d-inline-block form-check mb-0">
                                                <input type="checkbox" class="form-check-input mt-0"
                                                       id="test-other" name="filterUser" value="others">
                                                <label class="form-check-label"
                                                       for="test-other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 d-none" id="othersFilterSurfer">
                                    <input type="hidden" value="" name="surfer_id" id="surfer_id_filter" class="form-control surfer_id" />
                                    <input type="text" name="other_surfer" class="form-control ps-2 mb-0 filter_other_surfer">
                                    <div class="auto-search" id="filter_other_surfer_data"></div>
                                </div>
                            </div>-->
                            @endif
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">User Type</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                                        name="user_type" id="filter_user_type" multiple="multiple">
                                                    <option value="USER">Surfer</option>
                                                    <option value="PHOTOGRAPHER">Photographer</option>
                                                    <option value="SURFER CAMP">Surf Camp</option>
                                                    <option value="ADVERTISEMENT">Advertiser</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row align-items-center mb-4">
                                        <!--<div class=" align-items-center">-->
                                        <div class="col-md-4">
                                            <label for="surfe" class="form-label">Surfer</label>
                                        </div>
                                        <div class="col-md-8">
                                            @if(Auth::user())
                                            <div class="d-inline-block form-check mb-0 me-3">
                                                <input type="checkbox" class="form-check-input mt-0"
                                                       id="me-surfe" name="filterUser" value="me">
                                                <label class="form-check-label" for="me-surfe">Me</label>
                                            </div>
                                            @endif
                                            <div class="d-inline-block form-check mb-0">
                                                <input type="checkbox" class="form-check-input mt-0"
                                                       id="test-other" name="filterUser" value="others">
                                                <label class="form-check-label"
                                                       for="test-other">Other</label>
                                            </div>
                                        </div>
                                    <!--</div>-->
                                        
                                        
                                        
                                    </div>
                                    <div class="row align-items-center d-none mb-4" id="othersFilterSurfer">
                                        
                                     <div class="col-md-4">
                                            <label for="surfe" class="form-label"></label>
                                        </div>   
                                    <div class="col-md-8">    
                                    <input type="hidden" value="" name="surfer_id" id="surfer_id_filter" class="form-control surfer_id" />
                                    <input type="text" name="other_surfer" class="form-control ps-2 mb-0 filter_other_surfer" placeholder="Search">
                                    <div class="auto-search" id="filter_other_surfer_data"></div>
                                    </div>
                                    
                                    </div>
                                    
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Start Date</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <input class="form-control" type="date" name="surf_date" id="datepicker" value="{{ Request::get('surf_date') ? Request::get('surf_date') : "" }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">End Date</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <input class="form-control" type="date" name="end_date" id="datepicker" value="{{ Request::get('end_date') ? Request::get('end_date') : "" }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Country</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-control country local_beach_break_id" name="country_id" id="filter_country_id">
                                                    <option value="">-- Country --</option>
                                                    @foreach($countries as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                            {{ old('country_id',Request::get('country_id')) == $value->id ? "selected" : "" }}>
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">State</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-control" name="state_id" id="filter_state_id">
                                                    <option selected="selected" value="">-- State --</option>
                                                    @foreach($states as $key => $value)
                                                    <option value="{{ $value->id }}" 
                                                            {{ old('state_id',Request::get('state_id')) == $value->id ? "selected" : "" }}>
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Beach</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-select" name="beach" id="beach_filter">
                                                    <option value="">-- Beach --</option>
                                                    @foreach($beaches as $val)
                                                    @if(!empty($val['beach_name']))
                                                    <option value="{{$val['id']}}">{{$val['beach_name']}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Break</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-select" name="break" id="break_filter">
                                                    <option selected="selected" value="">-- Break --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Wave Size</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-control" name="wave_size">  
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['wave_size'] as $key => $value)
                                                    <option value="{{ $key }}" {{ old('wave_size',Request::get('wave_size')) == $key ? "selected" : "" }}>{{ $value}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Board Size</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="white-bg">
                                                <select class="form-control" name="board_type" id="board_type">
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['board_type'] as $key => $value)
                                                    <option value="{{ $key }}" {{ old('board_type',Request::get('board_type')) == $key ? "selected" : "" }}>{{ $value}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">Floater</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" name="FLOATER" {{ Request::get('FLOATER') ? "checked" : "" }} class="form-check-input mt-0"
                                                   id="floater">
                                            <label class="form-check-label" for="floater"></label>
                                        </div>
                                    </div>
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">Air</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input mt-0" {{ Request::get('AIR') ? "checked" : "" }} name="AIR" id="air">
                                            <label class="form-check-label" for="air"></label>
                                        </div>
                                    </div>
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">360</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input mt-0"
                                                   id="degree" {{ Request::get('360') ? "checked" : "" }} name="360">
                                            <label class="form-check-label" for="degree"></label>
                                        </div>
                                    </div>
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">Drop In</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input mt-0"
                                                   id="dropIn" {{ Request::get('DROP_IN') ? "checked" : "" }} name="DROP_IN">
                                            <label class="form-check-label" for="dropIn"></label>
                                        </div>
                                    </div>
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">Barrel</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input mt-0"
                                                   id="barrelRoll" {{ Request::get('BARREL_ROLL') ? "checked" : "" }} name="BARREL_ROLL">
                                            <label class="form-check-label" for="barrelRoll"></label>
                                        </div>
                                    </div>
                                    <div class="filter-checkbox mb-4">
                                        <label class="form-label">Wipeout</label>
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input mt-0"
                                                   id="wipeout" {{ Request::get('WIPEOUT') ? "checked" : "" }} name="WIPEOUT">
                                            <label class="form-check-label" for="wipeout"></label>
                                        </div>
                                    </div>
                                    <div class="align-items-center d-md-block d-none mb-4 row">

                                    </div>
                                    <div class="filter-checkbox start-rating mb-4">
                                        <label class="form-label">Start Rating</label>
                                        <div class="rating-flex" onclick="ratingShow(this)">
                                            <input id="rating" name="rating" class="rating-filter rating-loading" data-min="0" data-max="5" data-step="1" data-size="xs" value="0">                            
                                            <span class="avg-rating"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-5 d-none" id="additional_optional_info">

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="applyBtn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </form>
                    </div>

                    </div>


                    </div>
                    <script type="text/javascript">
                        jQuery('.rating-filter').rating({
                            showClear: false,
                            showCaption: false
                        });

                        function ratingShow(e) {
                            jQuery(e).children(".rating-container").show();
                            jQuery(e).children(".avg-rating").hide();
                        }
                        $(document).on('click', '.rating-container', function (e) {
                            jQuery(e).children(".rating-container").hide();
                            jQuery(e).children(".avg-rating").hide();
                        });

                    </script>
<div class="filter-sort">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    <button type="button" id="close" data-dismiss="modal" aria-label="Close"> Clear</button>
                </div>
            </div>
            <div class="filter-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row align-items-center mb-4">
                            <div class="col-md-4">
                                <label class="form-label">User Type</label>
                            </div>
                            <div class="col-md-8">
                                <div class="white-bg">
                                    <select class="form-control select2 select2-hidden-accessible country local_beach_break_id" name="user_type[]" id="filter_user_type" multiple="multiple">
                                        <option value="USER">Surfer</option>
                                        <option value="PHOTOGRAPHER">Photographer</option>
                                        <option value="SURFER CAMP">Surf Camp</option>
                                        <!-- <option value="ADVERTISEMENT">Advertiser</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Username</label>
                            </div>
                            <div class="col-md-8">
                                <div class="white-bg">
                                    <input type="hidden" value="" name="username_id" id="username_id_filter" class="form-control username_id" />
                                    <input type="text" name="filter_username" class="form-control ps-2 mb-0 filter_username" placeholder="Search Username">
                                    <div class="auto-search" id="filter_username_data"></div>
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
                                <div class="d-inline-block form-check mb-0">
                                    <input type="checkbox" class="form-check-input mt-0" id="test-other" name="filterUser" value="unknown">
                                    <label class="form-check-label" for="test-other">Unknown</label>
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
                                    <input type="text" value="{{ old('other_beach')}}" name="other_beach"class="form-control other_beach" placeholder="Search Beach" id="beach_filtername">
                                    <input type="hidden" value="{{ old('surfer_id')}}" name="beach" id="beach_id" class="form-control beach_id">
                                    <div class="auto-search search2 beachlist" id="filter_beach_data"></div>
                                    <!-- <select class="form-select" name="beach" id="beach_filter">
                                        <option value="">-- Beach --</option>
                                        @foreach($beaches as $val)
                                        @if(!empty($val['beach_name']))
                                        <option value="{{$val['id']}}">{{$val['beach_name']}}</option>
                                        @endif
                                        @endforeach
                                    </select> -->
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
                                    <select class="form-control" name="wave_size" id="wave_size">
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
                                <input type="checkbox" name="FLOATER" {{ Request::get('FLOATER') ? "checked" : "" }} class="form-check-input mt-0" id="floater">
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

                        <div class="row align-items-center mb-5 d-none" id="additional_optional_info"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"> </div>
                    <div class="col-md-4 text-center">
                        <button type="submit" class="applyBtn btn-primary">Apply Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('js/new/star-rating.min.js')}}"></script>
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

    $('#test-other').click(function () {
        if ($('#test-other').prop('checked')) {
            $('#othersFilterSurfer').removeClass('d-none');
        } else {
            $('#othersFilterSurfer').addClass('d-none');
        }
    });

    $(document).on('click', '#filter_other_surfer_data li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");

        $('.filter_other_surfer').val(value);
        $('#surfer_id_filter').val(dataId);
        $('#filter_other_surfer_data').html("");
    });

    $(document).on('click', '#filter_username_data li', function () {
        var value = $(this).text().trim();

        $('.filter_username').val(value);
        $('#filter_username_data').html("");
    });

    $('.filter_other_surfer').keyup(function () {
        // the following function will be executed every half second
        var userType = $('#filter_user_type').val();

        if ($(this).val().length > 1) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: "/getFilterUsers",
                data: {
                    user_type: userType,
                    searchTerm: $(this).val(),
                },
                dataType: "json",
                success: function (jsonResponse) {
                    $('#filter_other_surfer_data').html(jsonResponse);
                }
            });
        } else {
            $('#surfer_id_filter').val('');
            $('#filter_other_surfer_data').html("");
        }
    }); // Milliseconds in which the ajax call should be executed (100 = half second)

    /**
     * Get beach name typed by user and fetch data according to that
     */
    jQuery('#beach_filtername').on('keyup', function() {
        var beachValue = jQuery(this).val();
        //if ( beachValue.length > 3 ) {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: '/getBeachName',
                data: {
                    beach_name: beachValue,
                },
                dataType: "json",
                success: function (jsonResponse) {
                    // console.log(jsonResponse);

                    if (jsonResponse.status == 'success') {
                        var myJsonData = jsonResponse.data;
                        jQuery('#filter_beach_data').html(myJsonData);
                    }
                }
            });
        //}
    });

    /**
     * Replace first input by selecting beach name by user on list
     */
    jQuery(document).on('click', '.search2.beachlist li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#other_surfer_list').html("");
        jQuery('.other_beach').val(value);
        jQuery('#beach_id').val(dataId);
        jQuery('#filter_beach_data').html("");

        /** get all Break on the basis of Beach selected by user **/
        jQuery('#break_filter').find('option').remove();
        jQuery("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = dataId;
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '/getBreak',
            data: {
                beach_id: beachValue,
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;
                    jQuery.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            jQuery("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                        }
                    });
                }
            }
        });
    });

    /** Reset all form fields after submit manually **/
    jQuery('.filter-header #close').on('click', function() {
        jQuery("input[type=text]"). val("");
        jQuery("input[type=date]").val("");
        jQuery("#filter_country_id").find('option').attr('selected', false);
        jQuery("#break_filter").find('option').attr('selected', false);
        jQuery("#wave_size").find('option').attr('selected', false);
        jQuery("#board_type").find('option').attr('selected', false);
        jQuery('input[type=checkbox]').prop('checked', false);
    });
    /*$("#beach_filter").change(function (e) {
        $('#break_filter').find('option').remove();
        $("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '/getBreak',
            data: {
                beach_id: beachValue,
            },
            dataType: "json",
            success: function (jsonResponse) {
                //console.log(jsonResponse);
                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;

                    $.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            $("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                        }
                    });
                }
            }
        });
    });*/
</script>

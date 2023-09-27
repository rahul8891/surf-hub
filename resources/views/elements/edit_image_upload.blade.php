<div class="modal-dialog editPostM " role="document">
    <div class="modal-content">
    <form id="updateVideoPostData" method="POST" name="updatePostData" action="{{ route('updatePostData') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $myHubs->id }}">
        <div class="upload-wrap">
            <div class="upload-header">
                <h2>Upload Video/Photo</h2>
                <select class="form-select ps-2 mb-0" name="post_type" required>
                    @foreach($customArray['post_type'] as $key => $value)
                    <option value="{{ $key }}">{{ $value}}</option>
                    @endforeach
                </select>
            </div>
            <div class="upload-body">
                <input type="hidden" name="post_id" id="postIds" >
                <input type="hidden" name="user_id" value="{{auth()->user()->id ?? ''}}">
                <div class="multiple-photo-upload">
                    <div class=" align-items-start d-flex flex-wrap gap-4">
                        <div class="upload-photo-multiple" >
                            <div>
                                <img src="img/blue-upload-large.png">
                                <span>Drag files to<br>upload</span>
                            </div>
                            <button class="blue-btn btn">CHOOSE FILE</button>
                            <input type="file" id="input_multifileSelect2" name="files">
                        </div>
                        <div class="upload-file-name">
                            <!--                                    <div class="name-row">
                                                                    <img src="img/img-upload.png">
                                                                    <span>Photo.png 7.5 mb </span>
                                                                    <a href="#" class="remove-photo"> &#x2715;</a>
                                                                </div>
                                                                <div class="name-row">
                                                                    <img src="img/video-upload.png">
                                                                    <span>Photo.png 7.5 mb </span>
                                                                    <a href="#" class="remove-photo"> &#x2715;</a>
                                                                </div>-->
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <textarea class="form-control ps-2" placeholder="Share your surf experience..."
                              style="height: 80px" name="post_text">{{ (isset($myHubs->post_text) && !empty($myHubs->post_text))?$myHubs->post_text:'' }}</textarea>
                </div>
            </div>
            <div class="upload-header">
                <h2>Mandatory Info</h2>
            </div>

            <div class="upload-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Surf Date<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control ps-2 mb-0" type="date" name="surf_date" id="datepicker"
                                       value="{{ (isset($myHubs->surf_start_date) && !empty($myHubs->surf_start_date))?$myHubs->surf_start_date:'' }}" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Wave Size<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0" name="wave_size" required>
                                    <option value="">{{ __('-- Select --')}}</option>
                                    @foreach($customArray['wave_size'] as $key => $value)
                                    <option value="{{ $key }}"
                                            {{ $myHubs->wave_size == $key ? "selected" : "" }} >{{ $value}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Country<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0" name="country_id" id="country_id" district
                                        required>
                                    <option value="">-- Country --</option>
                                    @foreach($countries as $key => $value)
                                    <option value="{{ $value->id }}"
                                            {{ ( $value->id == $currentUserCountryId) ? 'selected' : '' }}>
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Beach<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <input type="text" value="{{ old('local_beach_break', $beach_name) }}"
                                       class="form-control ps-2 mb-0 search-box" name="local_beach_break" autocomplete="off" required>
                                <input type="hidden" name="local_beach_break_id"
                                       id="local_beach_break_id" class="form-control" value="{{ old('local_beach_break', $myHubs->local_beach_id) }}">
                                <div class="auto-search search12" id="country_list"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">State<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0" name="state_id" id="state_id" required>
                                    <option selected="selected" value="">-- State --</option>
                                    @foreach($states as $key => $value)
                                    <option value="{{ $value->id }}"
                                            {{ (isset($myHubs->state_id) && ($myHubs->state_id == $value->id)) ? "selected" : "" }}>
                                        {{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Break<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0" name="break_id" id="break_id">
                                    <option selected="selected" value="">-- Break --</option>
                                    @foreach($breaks as $key => $value)
                                    <option value="{{ $value->id }}"
                                            {{ (isset($breakId) && ($breakId == $value->id)) ? "selected" : "" }}>
                                        {{ $value->break_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-3">Surfer<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                @php
                                $username = Auth::user()->user_name;
                                $surfer = (isset($myHubs->surfer) && ($myHubs->surfer == $username))?'Me':$myHubs->surfer;
                                @endphp
                                @foreach ($customArray['surfer'] as $key => $value)
                                <div class="form-check d-inline-block me-3">
                                    <input class="form-check-input surfer-info" type="radio" name="surfer" value="{{$value}}"
                                           id="{{$value}}" required {{ ($surfer == $value) ? 'checked' : '' }} />
                                    <label for="{{$value}}" class="form-check-label">{{$value}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-none" id="othersSurferInfo">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4 d-md-block  d-none"></label>
                            <div class="col-md-8">
<!--                                        <input type="text" class="form-control ps-2 mb-0" placeholder="Search another user">-->
                                <input type="text" value="{{ old('other_surfer')}}" name="other_surfer"
                                       class="form-control ps-2 mb-0 edit_other_surfer" placeholder="Search another user" required>
                                <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id"
                                       id="edit_surfer_id" class="form-control surfer_id">
                                <div class="auto-search searchOther" id="edit_other_surfer_list"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="upload-header">
                <h2>Optional Info</h2>
            </div>
            <div class="upload-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Fin Set Up<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0">
                                    <option selected=""></option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Stance<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0">
                                    <option selected="">Goofy</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upload-header p-0"></div>
            <div class="upload-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-4">Board Type<span class="red-txt">*</span></label>
                            <div class="col-md-8">
                                <select class="form-select ps-2 mb-0" name="board_type">
                                    <option value="">{{ __('-- Select --')}}</option>
                                    @foreach($customArray['board_type'] as $key => $value)
                                    <option value="{{ $key }}"
                                            {{ (isset($myHubs->board_type) && ($myHubs->board_type == $key)) ? "selected" : "" }}>{{ $value}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-3 align-items-center">
                            <label class="col-md-2"></label>
                            <div class="col-md-8">
                                <div class="row">
                                    @php
                                    $optional = explode(" ", $myHubs->optional_info);
                                    @endphp
                                    @foreach($customArray['optional'] as $key => $value)
                                    <div class="col-sm-4 col-6">
                                        <div class="form-check d-inline-block">
                                            <input type="checkbox" class="form-check-input" name="optional_info[]" value="{{ __($key) }}"
                                                   id="{{ __($key) }}" {{ in_array(__($key), $optional) ? "checked='''checked'":"" }} />
                                            <label for="{{ __($key) }}" class="">{{ __($value) }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-10">
                    <button class="btn blue-btn w-150" type="submit">UPLOAD</button>
                </div>
            </div>


        </div>
    </form>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function () {
        /**
         * Execute a function given a delay time
         * 
         * @param {type} func
         * @param {type} wait
         * @param {type} immediate
         * @returns {Function}
         */
       
        
        var debounce = function (func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate)
                        func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow)
                    func.apply(context, args);
            };
        };

        // ajax form field data for post
        $('.search-box').keyup(debounce(function () {
            // the following function will be executed every half second	
            if ($(this).val().length > 2) {
                $.ajax({
                    type: "GET",
                    url: "/getBeachBreach",
                    data: {
                        searchTerm: $(this).val(),
                    },
                    dataType: "json",
                    success: function (jsonResponse) {
                        $('#country_list').html(jsonResponse);
                    }
                });

            } else {
                $('#local_beach_break_id').val('');
                $('#country_list').html("");
            }

        }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

        
        

        // get application base url
        var base_url = window.location.origin;
        $(".input_multifileSelect1").change(function (event) {
            var file = event.target.files[0];

            if (file.type.match('image')) {
                $(".pip").remove();
                $(".input_multifileSelect2").val('');

                var fileReader = new FileReader();
                fileReader.onload = function (e) {
                    var file = e.target;

                    $("<span class=\"pip\">" +
                            "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                            "</span>").insertAfter("#filesInfoEdit");
                };
                fileReader.readAsDataURL(file);
            }
        });

        $(".input_multifileSelect2").change(function (event) {
            var file = event.target.files[0];

            if (file.type.match('video')) {
                console.log('11111');
                $(".pip").remove();
                $(".input_multifileSelect1").val('');


                $("<span class=\"pip\">" +
                        "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"/img/play.png\" title=\"" + file.name + "\"/>" +
                        "<br/><span class=\"remove\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                        "</span>").insertAfter("#filesInfoEdit");

            }
        });

        $(".submitBtn").click(function () {
            $("#updateVideoPostData").submit();
        });


        $('.surfer-info').click(function () {
            if ($(this).val() == "Others") {
                $('#othersSurferInfo').removeClass('d-none');
            } else {
                $('#othersSurferInfo').addClass('d-none');
            }
        });

        $('.edit_other_surfer').keyup(debounce(function () {
            // the following function will be executed every half second	
            if ($(this).val().length > 2) {
                $.ajax({
                    type: "GET",
                    url: "/getUsers",
                    data: {
                        searchTerm: $(this).val(),
                    },
                    dataType: "json",
                    success: function (jsonResponse) {
                        $('#edit_other_surfer_list').html(jsonResponse);
                    }
                })
            } else {
                $('#edit_surfer_id').val('');
                $('#edit_other_surfer_list').html("");
            }
        }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

       
        $(document).on('click', '.searchOther li', function () {
            var value = $(this).text().trim();
            var dataId = $(this).attr("data-id");
            $('#edit_other_surfer_list').html("");
            $('.edit_other_surfer').val(value);
            $('#edit_surfer_id').val(dataId);
            $('#edit_other_surfer_list').html("");
        });
        
        $(document).on('click', '.search12', function () {
            
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list').html("");
        $('.search-box').val(value);
        $('#local_beach_break_id').val(dataId);
        $('#country_list').html("");
    });
    
    
    
    });
    
     function setBeach(data) {
        var dataId = data.getAttribute("data-id");
        var value = $(data).text();
        $('#country_list').html("");
        $('.search-box').val(value);
        $('#local_beach_break_id').val(dataId);
        getBreak(dataId);
        $('#country_list').html("");
    }
    function getBreak(beachValue) {
//        var beachValue = $(this).val();
        if (beachValue != 0) {
            $.ajax({
                type: "GET",
                url: '/getBreak',
                data: {
                    beach_id: beachValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        $("#break_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#break_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            if(value.break_name!='') {
                            $("#break_id").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                            $("#break_id").rules( "add", {required: true,messages: { required: "Break is required"}});

                        } else {
                            $("#break_id").rules( "remove" );
                        }
                        });
                    } else {
                        $("#break_id").empty();
                    }
                }
            });
        } else {
            $("#break_id").empty();
        }
    }
    
</script>
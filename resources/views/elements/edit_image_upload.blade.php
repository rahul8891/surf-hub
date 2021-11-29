    <div class="modal-dialog">
        <form id="updateVideoPostData" method="POST" name="updatePostData" action="{{ route('updatePostData') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $myHubs->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}">Edit Post</h5>
                    <div class="selectWrap pos-rel">
                        <select class="form-control" name="post_type" required>
                            @foreach($customArray['post_type'] as $key => $value)
                            <option value="{{ $key }}">{{ $value}}</option>
                            @endforeach
                        </select>
                        <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                    </div>
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"
                        onclick="this.form.reset();">
                        <img alt="" src="{{ asset("/img/close.png")}}">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <input type="hidden" name="user_id" value="{{auth()->user()->id ?? ''}}">
                        <textarea placeholder="Share your surf experience....." name="post_text" >{{ (isset($myHubs->post_text) && !empty($myHubs->post_text))?$myHubs->post_text:'' }}</textarea>
                        <div class="videoImageUploader">
                            <div class="upload-btn-wrapper">
                                <button class=""><img alt="" src="{{ asset("/img/photo.png")}}"></button>
                                <input type="file" class="input_multifileSelect1" name="files" accept=".png, .jpg, .jpeg, .gif"
                                       multiple />
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class=""><img alt="" src="{{ asset("/img/video.png")}}"></button>
                                <input type="file" class="input_multifileSelect2" name="videos" accept=".mp4, .wmv, .mkv, .mpeg4, .mov" multiple />
                            </div>
                        </div>
                        <div class="row" id="filesInfoEdit"></div>

                        <span id="imageError" class="notDisplayed required">{{ __('Please upload files having extensions: jpg, jpeg, png') }}</span>
                        <span id="videoError" class="notDisplayed required">{{ __('Please upload files having extensions: mp4, wmv, mkv, mpeg4, mov') }}</span>
                            
                        </div>

                        <span id="imageError" class="notDisplayed required">{{ __('Please upload files having extensions: jpg, jpeg, png') }}</span>
                        <div class="formWrap">
                            <h2>Mandatory Info</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Surf Date <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <input class="form-control" type="date" name="surf_date" id="datepicker"
                                                    value="{{ (isset($myHubs->surf_start_date) && !empty($myHubs->surf_start_date))?$myHubs->surf_start_date:'' }}" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Wave size <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="wave_size" required>
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['wave_size'] as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ $myHubs->wave_size == $key ? "selected" : "" }}>{{ $value}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>  
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Country <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="country_id" id="country_id" district
                                                    required>
                                                    <option value="">-- Country --</option>
                                                    @foreach($countries as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ ( $value->id == $currentUserCountryId) ? 'selected' : '' }}>
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="width-102">Beach / Break <span
                                                    class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <input type="text" value="{{ old('local_beach_break', $beach_name) }}"
                                                    name="local_beach_break" placeholder="Break / Beach Name"
                                                    class="form-control search-box" required>
                                                <input type="hidden" name="local_beach_break_id"
                                                       id="local_beach_break_id" class="form-control" value="{{ old('local_beach_break', $myHubs->local_beach_break_id) }}">
                                                <!-- <div class="auto-search country_list_beach search1"></div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>State <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="state_id" id="edit_state_id" required>
                                                    <option selected="selected" value="">-- State --</option>
                                                    @foreach($states as $key => $value)
                                                    <option value="{{ $value->id }}" {{ (isset($myHubs->state_id) && ($myHubs->state_id == $value->id)) ? "selected" : "" }} >
                                                        {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="width-102">Board Type <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="board_type" required>
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['board_type'] as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ (isset($myHubs->board_type) && ($myHubs->board_type == $key)) ? "selected" : "" }}>{{ $value}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Surfer <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex">
                                                @php
                                                    $username = Auth::user()->user_name;
                                                    $surfer = (isset($myHubs->surfer) && ($myHubs->surfer == $username))?'Me':$myHubs->surfer;
                                                @endphp
                                                @foreach ($customArray['surfer'] as $key => $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input surfer-info" type="radio" name="surfer" value="{{ $value }}" id="{{ strtolower($value) }}" required {{ ($surfer == $value) ? 'checked' : '' }} />
                                                    <label for="{{ strtolower($value) }}" class="form-check-label text-primary">{{ $value }}</label>
                                                </div>
                                                @endforeach
                                            </div>  
                                        </div>
                                    </div>
                                        <div class="col-md-8 col-sm-4 float-right othersSurferInfo" style="display:none" id="othersSurfer">
                                              <div class="selectWrap pos-rel">
                                                <div class="selectWrap pos-rel">
                                                    <input type="text" value="{{ old('other_surfer')}}" name="other_surfer" placeholder="Search other user" class="form-control edit_other_surfer">
                                                        <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id" id="edit_surfer_id" class="form-control surfer_id">
                                                    <div class="auto-search search2" id="edit_other_surfer_list"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="formWrap optionalFields">
                            <h2>Optional Info</h2>
                            <div class="row">
                                <div class="col-md-3 align-self-end">
                                    <img src="{{ asset("/img/img_4.jpg")}}" alt="" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        @php
                                            $optional = explode(" ", $myHubs->optional_info);
                                        @endphp
                                        @foreach($customArray['optional'] as $key => $value)
                                        <div class="col-md-4 pl-1 pr-1 col-6">
                                            <div class="cstm-check pos-rel">
                                                <input type="checkbox" name="optional_info[]" value="{{ __($key) }}"
                                                    id="{{ __(strtolower($key)) }}"  {{ in_array(__($key), $optional) ? "checked='''checked'":"" }} />
                                                <label for="{{ __(strtolower($key)) }}" class="">{{ __($value) }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-3 align-self-end">
                                    <img src="{{ asset("/img/filterRightIcon.jpg")}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center justify-content-center">
                        <!-- <button type="reset">RESET</button> 
                        <button type="submit" form="updateVideoPostData" class="submitBtn">UPLOAD</button> -->
                        <input type="submit" class="uploadPost" name="submit" value="SAVE" />
                    </div>
                    </div>
                    
                </div>
                </form>
            </div>
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
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
	};
        
        // ajax form field data for post
	$('.search-box').keyup(debounce(function() { 
            // the following function will be executed every half second	
            if($(this).val().length > 2){		
                $.ajax({
                    type: "GET",
                    url: "/getBeachBreach",
                    data: {				
                        searchTerm: $(this).val(),
                    },
                    dataType: "json",
                    success: function (jsonResponse) {
                        $('.country_list_beach').html(jsonResponse);
                    }
                });

            } else {
                $('#local_beach_break_id').val('');
                $('#country_list').html("");
            }

        },100)); // Milliseconds in which the ajax call should be executed (500 = half second)
        
        // get application base url
        var base_url = window.location.origin;
        $(".input_multifileSelect1").change(function (event) {
            var file = event.target.files[0];
            
            if (file.type.match('image')) {
                $(".pip").remove();
                $(".input_multifileSelect2").val('');
                
                var fileReader = new FileReader();
                fileReader.onload = function(e) {
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
            
            if (file.type.match('video')) {  console.log('11111');
                $(".pip").remove();
                $(".input_multifileSelect1").val('');
                
                
                    $("<span class=\"pip\">" +
                            "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"/img/play.png\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                            "</span>").insertAfter("#filesInfoEdit");
               
            }
        });
        
        $(".submitBtn").click(function() {
            $("#updateVideoPostData").submit();
        });
        
        
        $('.surfer-info').click(function() {
            if ($(this).val() == "Others") {
                $('.othersSurferInfo').show();
            } else {
                $('.othersSurferInfo').hide();
            }
        });
        
        $('.edit_other_surfer').keyup(debounce(function(){
            // the following function will be executed every half second	
            if($(this).val().length > 2){
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
            }else{
                $('#edit_surfer_id').val('');
                $('#edit_other_surfer_list').html("");
            }
        }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)
        
        $(document).on('click','.search2 li', function(){
            var value = $(this).text().trim();
            var dataId = $(this).attr("data-id");
            $('#edit_other_surfer_list').html("");
            $('.edit_other_surfer').val(value);
            $('#edit_surfer_id').val(dataId);
            $('#edit_other_surfer_list').html("");
        });
    }); 
</script>
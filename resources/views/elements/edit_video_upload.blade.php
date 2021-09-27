    <div class="modal-dialog" role="document">
        <form id="updateVideoPostData" method="POST" name="updatePostData" action="{{ route('updatePostData') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $myHubs->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}">Upload
                        Video</h5>
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
                        <textarea placeholder="Share your surf experience....." name="post_text" required>{{ (isset($myHubs->post_text) && !empty($myHubs->post_text))?$myHubs->post_text:'' }}</textarea>
                        <div class="videoImageUploader">
                            <div class="upload-btn-wrapper">
                                <a data-toggle="modal" data-target="#editVideoModal"><img alt="" src="{{ asset("/img/video.png")}}"></a>
                                <div class="editUploadVideoFiles"></div>
                            </div>
                        </div>
                        <div class="row" id="filesInfo">
                            
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
                                                <!-- <div class="auto-search search1" id="country_list"></div> -->
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
                                                <select class="form-control" name="state_id" id="state_id" required>
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
                                                    <input class="form-check-input" type="radio" name="surfer" value="{{$value }}" id="{{$value}}" required {{ ($surfer == $value) ? 'checked' : '' }} />
                                                    <label for="{{$value}}" class="form-check-label text-primary">{{$value}}</label>
                                                </div>
                                                @endforeach
                                            </div>  
                                        </div>
                                    </div>
                                        <div class="col-md-8 col-sm-4 float-right" style="display:none" id="othersSurfer">
                                              <div class="selectWrap pos-rel">
                                                <div class="selectWrap pos-rel">
                                                    <input type="text" value="{{ old('other_surfer')}}" name="other_surfer"
                                                        placeholder="Search other user" class="form-control other_surfer" required>
                                                        <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id"
                                                        id="surfer_id" class="form-control surfer_id">
                                                    <div class="auto-search search2" id="other_surfer_list"></div>
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
                                                    id="{{ __($key) }}"  {{ in_array(__($key), $optional) ? "checked='''checked'":"" }} />
                                                <label for="{{ __($key) }}" class="custom-control-label">{{ __($value) }}</label>
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
                    </div>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <!-- <button type="reset">RESET</button> -->
                    <button type="submit">UPLOAD</button>
                </div>
            </div>
        </form>
    </div>

@include('elements/edit_popup_upload')
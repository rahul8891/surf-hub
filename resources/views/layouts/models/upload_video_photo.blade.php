<div class="modal fade uploadModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="postForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><img src="{{ asset("/img/logo_small.png")}}">Upload
                        Video/Photo</h5>
                    <div class="selectWrap pos-rel">
                        <select class="form-control" name="post_type" required>
                            @foreach($customArray['post_type'] as $key => $value)
                            <option value="{{ $key }}">{{ $value}}</option>
                            @endforeach
                        </select>
                        <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="this.form.reset();">
                        <img alt="" src="{{ asset("/img/close.png")}}">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <textarea placeholder="Share your surf experience....." name="post_text"></textarea>
                        <div class="videoImageUploader">
                            <div class="upload-btn-wrapper">
                                <button class=""><img alt="" src="{{ asset("/img/photo.png")}}"></button>
                                <input type="file" name="surf_image[]" multiple />
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class=""><img alt="" src="{{ asset("/img/video.png")}}"></button>
                                <input type="file" name="surf_video[]" multiple />
                            </div>
                            <div class="upload-btn-wrapper">
                                <button class=""><img alt="" src="{{ asset("/img/tag-friend.png")}}"></button>
                            </div>
                        </div>
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
                                                <input class="form-control" type="date" name="surf_date"
                                                    id="datepicker" />
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
                                                <select class="form-control" name="wave_size">
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['wave_size'] as $key => $value)
                                                    <option value="{{ $key }}">{{ $value}}</option>
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
                                                <select class="form-control" name="country_id">
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
                                                <select class="form-control" name="local_beach_break_id">
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
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
                                                <select class="form-control" name="state_id">
                                                    <option value="">-- State --</option>
                                                    @foreach($states as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ old('state_id') == $value->id ? "selected" : "" }}>
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
                                            <label>Board Type <span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="board_type">
                                                    <option value="">{{ __('-- Select --')}}</option>
                                                    @foreach($customArray['board_type'] as $key => $value)
                                                    <option value="{{ $key }}">{{ $value}}</option>
                                                    @endforeach
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>Surfer<span class="mandatory">*</span></label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex meOthersCheck">
                                                <div class="cstm-check pos-rel">
                                                    <input type="radio" name="surfer" value="me" id="Me" required />
                                                    <label for="Me" class="">Me</label>
                                                </div>
                                                <div class="cstm-check pos-rel">
                                                    <input type="radio" name="surfer" value="other" id="Others" />
                                                    <label for="Others" class="">Others</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8" style="display:none" id="otherSsurfer">
                                            <div class="selectWrap pos-rel">
                                                <select class="form-control" name="other_surfer" id="other_surfer">
                                                    <option value=""></option>
                                                    <option value="1">Sandeep</option>
                                                    <option value="2">Raja</option>
                                                    <option value="3">Raman</option>
                                                    <option value="4">Sanoj</option>
                                                </select>
                                                <span><img src="{{ asset("/img/select-downArrow.png")}}" alt=""></span>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-4">
                                            <div class="cstm-check pos-rel">
                                                <input type="radio" name="surfer" id="Unknown" value="unknown" />
                                                <label for="Unknown" class="">Unknown</label>
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
                                        @foreach($customArray['optional'] as $key => $value)
                                        <div class="col-md-4 pl-1 pr-1 col-6">
                                            <div class="cstm-check pos-rel">
                                                <input type="checkbox" name="optional_info[]" value="{{ __($key) }}"
                                                    id="{{ __($key) }}" />
                                                <label for="{{ __($key) }}" class="">{{ __($value) }}</label>
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
</div>
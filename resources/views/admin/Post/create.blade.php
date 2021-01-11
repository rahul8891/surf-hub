@extends('layouts.admin.master')
@section('content')
<!--/. container-fluid -->

<!-- right column -->
<div class="col-md-12">
    <!-- general form elements disabled -->
    <!-- <div id="loader"></div> -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
        </div>
        <!-- /.card-header -->
        <form role="form" id="postForm" name="postForm" method="POST" action="{{ route('postStore') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Post Type <span class="required">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="selectWrap pos-rel">
                                    <select class="form-control" name="post_type" required>
                                        <option value="">{{ __('-- Select --')}}</option>
                                        @foreach($customArray['post_type'] as $key => $value)
                                        <option value="{{ $key }}" {{ old('post_type') == $key ? "selected" : "" }}>
                                            {{ $value}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('post_type')
                                <strong class="required">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_id">User<span class="required">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="selectWrap pos-rel">
                                    <select class="form-control" name="user_id" required>
                                        <option value="">{{ __('-- Select --')}}</option>
                                        @foreach($users as $key => $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('user_name') == $key ? "selected" : "" }}>{{ $value->user_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <hr />

                <h2 class="text-primary">Upload Video/Photo</h2>
                <div class="form-group">
                    <textarea placeholder="Share your surf experience....." name="post_text"
                        class="form-control has-success" rows="3"></textarea>
                    <hr />
                    <div class="videoImageUploader">
                        <div class="upload-btn-wrapper">
                            <button type="button" id="file_button" class="btn"><img alt="" src="{{ asset("/img/photo.png")}}"></button>
                            <input type="file" id="input_multifileSelect1" name="files[]" accept=".png, .jpg, .jpeg"
                                multiple />
                        </div>
                        <div class="upload-btn-wrapper">
                            <button type="button" id="video_button" class="btn"><img alt="" src="{{ asset("/img/video.png")}}"></button>
                            <input type="file" id="input_multifileSelect2" name="videos[]" accept=".mp4, .wmv, .mkv, .gif, .mpeg4" multiple />
                        </div>
                    {{-- <div class="upload-btn-wrapper">
                            <button class=""><img alt="" src="{{ asset("/img/tag-friend.png")}}"></button>
                </div> --}}
                    </div>
                </div>
    <hr />
    <div class="formWrap">
        <h2 class="text-primary">Mandatory Info</h2>
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>Surf Date <span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="selectWrap pos-rel">
                            <input class="form-control" type="date" name="surf_date" id="datepicker"
                                value="{{ old('surf_date') }}" required />
                        </div>
                        @error('surf_date')
                        <strong class="required">{{ $message }}</strong>
                        @enderror
                     </div>                          
                </div>

            </div>
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>Wave size <span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="selectWrap pos-rel">
                            <select class="form-control" name="wave_size" required>
                                <option value="">{{ __('-- Select --')}}</option>
                                @foreach($customArray['wave_size'] as $key => $value)
                                <option value="{{ $key }}" {{ old('wave_size') == $key ? "selected" : "" }}>{{ $value}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('wave_size')
                        <strong class="required">{{ $message }}</strong>
                        @enderror
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>Country <span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="selectWrap pos-rel">
                            <select class="form-control select2 select2-hidden-accessible country local_beach_break_id"
                                name="country_id" id="country_id" required>
                                <option value="">-- Country --</option>
                                @foreach($countries as $key => $value)
                                <option value="{{ $value->id }}"
                                    {{ old('country_id') == $value->id ? "selected" : "" }}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <strong class="required">{{ $message }}</strong>
                            @enderror

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label class="width-102">Beach / Break <span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="selectWrap pos-rel">
                            <input type="text" value="{{ old('local_beach_break')}}" name="local_beach_break"
                                placeholder="Your Local Beach / Break" class="form-control search-box" required>
                            <input type="hidden" value="{{ old('local_beach_break_id')}}" name="local_beach_break_id"
                                id="local_beach_break_id" class="form-control">
                            <div class="auto-search search1" id="country_list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>State</label>
                    </div>
                    <div class="col-md-8">
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
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>Board Type<span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="selectWrap pos-rel">
                            <select class="form-control" name="board_type" required>
                                <option value="">{{ __('-- Select --')}}</option>
                                @foreach($customArray['board_type'] as $key => $value)
                                <option value="{{ $key }}" {{ old('board_type') == $key ? "selected" : "" }}>{{ $value}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('board_type')
                        <strong class="required">{{ $message }}</strong>
                        @enderror
                    </div>
            </div>
        </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label>Surfer<span class="required">*</span></label>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex">
                            @foreach ($customArray['surfer'] as $key => $value)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="surfer" value="{{$value}}"
                                    id="{{$value}}" required/>
                                <label for="{{$value}}" class="form-check-label text-primary">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>  
                        @error('surfer')
                        <strong class="required">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8 col-sm-4 float-right" style="display:none" id="othersSurfer">
                    
                    <div class="selectWrap pos-rel">
                        <input type="text" value="{{ old('other_surfer')}}" name="other_surfer"
                            placeholder="@ Search other user" class="form-control other_surfer" required>
                        <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id"
                            id="surfer_id" class="form-control surfer_id">
                        <div class="auto-search search2" id="other_surfer_list"></div>
                    </div>
                </div>
            </div>
        
    </div>

    <hr />
    <div class="formWrap optionalFields">
        <h2 class="text-primary">Optional Info</h2>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="row">
                    @foreach($customArray['optional'] as $key => $value)
                    <div class="col-md-4 pl-1 pr-1 col-6">
                        <div class="cstm-check pos-rel">
                            <input type="checkbox" name="optional_info[]" value="{{ __($key) }}" id="{{ __($key) }}" />
                            <label for="{{ __($key) }}" class="">{{ __($value) }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.card-body -->
<div class="card-footer">
    <a href="{{ route('postIndex')}}" class="btn btn-default">Back</a>
    <button type="submit" id="next1" class="btn btn-info float-right">Submit</button>
</div>
</form>
<!-- /.card-footer -->
</div>
@endsection
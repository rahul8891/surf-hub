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
        <form role="form" id="postForm" name="postForm" method="POST" action="{{ route('postUpdate',Crypt::encrypt($posts->id)) }}" enctype="multipart/form-data">
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
                                        <option value="{{ $key }}"
                                            {{ old('post_type',$posts->post_type) == $key ? "selected" : "" }}>{{ $value}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                            
                        </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_id">By User<span class="required">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="selectWrap pos-rel">
                                    <select class="form-control" name="user_id" readonly required>
                                    <option value="{{$posts->user_id}}" selected
                                        {{ old('user_name',$posts->user_id)}}>{{ $posts->user->user_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                        
                        </div>
    
                    </div>
                    <hr/>

                <h1>Upload Video/Photo</h1>
                <hr/>
                <div class="image-wrapper">
                    @if (!empty($postMedia))
                        @foreach (explode(' ', json_decode($postMedia, true)[0]['image'] ?? '') as $postImage)
                            <img src="{{ asset('storage/images/'.$postImage) }}" class="img-fluid img-thumbnail rounded mx-auto px-2" width="10%" alt="No photo attached">
                        @endforeach
                        <hr/>
                        @foreach (explode(' ', json_decode($postMedia, true)[0]['video'] ?? '') as $postVideo)
                            <video width="200" height="150" controls="true">
                            <source src="{{ asset('storage/videos/'.$postVideo) }}" type="" />
                            </video>
                        @endforeach
                   @endif 
                </div>
                <hr/>
                <div class="form-group">
                <textarea placeholder="Share your surf experience....." name="post_text" autofocus required class="form-control" rows="3" >{{ old('post_text',$posts->post_text) }}</textarea>
                    <div class="videoImageUploader">
                        <div class="upload-btn-wrapper">
                            <button class=""><img alt="" src="{{ asset("/img/photo.png")}}"></button>

                            <input type="file" id="input_multifileSelect" name="files[]" accept=".png, .jpg, .jpeg"
                            multiple />

                            <!-- <input type="hidden" id="imagebase64Multi" name="surf_image_array[]"
                                accept=".png, .jpg, .jpeg" multiple /> -->
                        </div>
                        <div class="upload-btn-wrapper">
                            <button class=""><img alt="" src="{{ asset("/img/video.png")}}"></button>
                            <input type="file" name="videos[]" multiple />
                        </div>
                        {{-- <div class="upload-btn-wrapper">
                            <button class=""><img alt="" src="{{ asset("/img/tag-friend.png")}}"></button>
                        </div> --}}
                    </div>
                </div>
                <hr/>
                <div class="formWrap">
                    {{-- <p>{{$posts->surf_start_date}}</p>
                    <p>{{date_format(date_create($posts->surf_start_date),"m/d/Y")}}</p>
                    <p>{{date('m/d/yy', strtotime($posts->surf_start_date))}}</p>
                    <p>{{ \Carbon\Carbon::parse($posts->surf_start_date)->format('m/d/Y')}}</p> --}}
                    <h2 class="text-primary">Mandatory Info</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Surf Date <span class="required">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="selectWrap pos-rel">
                                        <input class="form-control" type="date" name="surf_date" id="datepicker"
                                            value="{{ old('surf_date'),$posts->surf_start_date }}" required />
                                    </div>
                                    @error('surf_date')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Wave size <span class="required">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="selectWrap pos-rel">
                                        <select class="form-control" name="wave_size" required>
                                            <option value="">{{ __('-- Select --')}}</option>
                                            @foreach($customArray['wave_size'] as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('wave_size',$posts->wave_size) == $key ? "selected" : "" }}>{{ $value}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('wave_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                         @enderror
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6">
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
                                    {{ ( $value->id == $posts->country_id) ? 'selected' : '' }}>
                                    {{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="width-102">Beach / Break <span
                                            class="required">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="selectWrap pos-rel">
                                        <div class="form-group">
                                            @php
                                            $bb=$posts->beach_breaks;
                                            $beach_break = $bb->beach_name.','.$bb->break_name
                                            .''.$bb->city_region.','.$bb->state.','.$bb->country;
                                            @endphp
                                            <input type="text"
                                                class="form-control @error('local_beach_break') is-invalid @enderror search-box"
                                                name="local_beach_break" placeholder="Search Beach Break "
                                                value="{{ old('local_beach_break',$beach_break)}}">
                                            @error('local_beach_break')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <input type="hidden"
                                                value="{{old('local_beach_break',$posts->local_beach_break_id )}}"
                                                name="local_beach_break_id" id="local_beach_break_id" class="form-control">
                
                                            <div class="auto-search search1" id="country_list"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>State <span class="required">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <div class="selectWrap pos-rel">
                                        <select class="form-control" name="state_id" id="state_id">
                                            <option selected="selected" value="">-- State --</option>
                                            @foreach($states as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ ( old('state_id',$posts->state_id) == $key) ? 'selected' : '' }}>
                                                {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Board Type</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="selectWrap pos-rel">
                                        <select class="form-control" name="board_type" required>
                                            <option value="">{{ __('-- Select --')}}</option>
                                            @foreach($customArray['board_type'] as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('board_type',strtoupper($posts->board_type)) == $key ? "selected" : "" }}>{{ $value}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Surfer<span class="required">*</span></label>
                                </div>  
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        @foreach ($customArray['surfer'] as $key => $value)
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="surfer" {{old('surfer',$posts->surfer) == $value ? 'checked' : ''}}  value="{{$value}}" id="{{$value}}" required />
                                            <label for="" class="form-check-label text-primary">{{$value}}</label>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-4 col-sm-8" style="display:none" id="othersSurfer">
                                    <div class="selectWrap pos-rel">

                                        <!-- <input type="text" value="{{ old('other_surfer')}}" name="other_surfer"
                                            placeholder="Search User " class="form-control other_surfer_box"
                                            id="other_surfer" required>

                                        <input type="hidden" name="user_id" id="user_id" class="form-control">

                                        <div class="auto-search search1" id="other_surfer_list"></div> -->

                                        <select class="form-control" name="other_surfer" id="other_surfer">
                                            <option value="">-- Select User --</option>
                                            <option value="1">Sandeep</option>
                                            <option value="2">Raja</option>
                                            <option value="3">Raman</option>
                                            <option value="4">Sanoj</option>
                                        </select>

                                        
                                </div>
                            </div>
                            @error('surfer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr/>
                <div class="formWrap optionalFields">
                    <h2 class="text-primary">Optional Info</h2>
                    <div class="row">
                        <div class="col-md-3 align-self-end">
                            <img src="{{ asset("/img/img_4.jpg")}}" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                @foreach($customArray['optional'] as $key => $value)
                                <div class="col-md-4 pl-1 pr-1 col-6">
                                    <div class="cstm-check pos-rel">
                                        <input type="checkbox" name="optional_info[]" 
                                        {{(in_array($key, old('optional_info[]', explode(" ",$posts->optional_info))))? 'checked' : ''}}  value="{{ __($key) }}"
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
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ route('postIndex')}}" class="btn btn-default">Back</a>
                <button type="submit" id="next1" class="btn btn-info float-right">Submit</button>
            </div>
        </form>
        <!-- /.card-footer -->
    </div>
    @endsection
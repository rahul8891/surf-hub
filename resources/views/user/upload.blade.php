@extends('layouts.user.new_layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />

<section class="home-section">

    <div class="container">
        <div class="home-row">

            @include('layouts.user.left_sidebar')    

            <div class="middle-content">
            <form class="" id="my-great-dropzone" method="POST" name="postForm" action="{{ route('storeVideoImagePost') }}" class="upload-form" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
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
                                    <input type="file" id="input_multifileSelect2" name="files[]" multiple="multiple">
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
                                      style="height: 80px" name="post_text"></textarea>
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
                                                       value="{{ old('surf_date') }}" required />
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
                                                            {{ old('wave_size') == $key ? "selected" : "" }}>{{ $value}}
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
                                        <input type="text" value="{{ old('local_beach_break')}}"
                                                  class="form-control ps-2 mb-0 search-box" name="local_beach_break" autocomplete="off" required>
                                            <input type="hidden" name="local_beach_break_id"
                                                   id="local_beach_break_id" class="form-control">
                                            <div class="auto-search search1" id="country_list"></div>
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
                                                        {{ old('state_id') == $value->id ? "selected" : "" }}>
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
                                        
                                        @foreach ($customArray['surfer'] as $key => $value)
                                        <div class="form-check d-inline-block me-3">
                                            <input class="form-check-input" type="radio" name="surfer" value="{{$value}}"
                                                   id="{{$value}}" required/>
                                            <label for="{{$value}}" class="form-check-label">{{$value}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="othersSurfer">
                            <div class="col-md-6">
                                <div class="row mb-3 align-items-center">
                                    <label class="col-md-4 d-md-block d-none"></label>
                                    <div class="col-md-8">
<!--                                        <input type="text" class="form-control ps-2 mb-0" placeholder="Search another user">-->
                                    <input type="text" value="{{ old('other_surfer')}}" name="other_surfer"
                                               class="form-control ps-2 mb-0 other_surfer" placeholder="Search another user" required>
                                        <input type="hidden" value="{{ old('surfer_id')}}" name="surfer_id"
                                               id="surfer_id" class="form-control surfer_id">
                                        <div class="auto-search search2" id="other_surfer_list"></div>
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
                            <div class="col-md-12">
                                <div class="row mb-3 align-items-center">
                                    <label class="col-md-2"></label>
                                    <div class="col-md-8">
                                        <div class="row">
                                            @foreach($customArray['optional'] as $key => $value)
                                <div class="col-sm-4 col-6">
                                    <div class="form-check d-inline-block">
                                        <input type="checkbox" class="form-check-input" name="optional_info[]" value="{{ __($key) }}"
                                               id="{{ __($key) }}" />
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
                                                        {{ old('board_type') == $key ? "selected" : "" }}>{{ $value}}
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
                                            @foreach($customArray['optional'] as $key => $value)
                                <div class="col-sm-4 col-6">
                                    <div class="form-check d-inline-block">
                                        <input type="checkbox" class="form-check-input" name="optional_info[]" value="{{ __($key) }}"
                                               id="{{ __($key) }}" />
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

            <div class="right-advertisement">
                <img src="img/advertisement1.png" alt="advertisement">
                <img src="img/advertisement2.png" alt="advertisement">
            </div>

        </div>
    </div>
</section>

@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
<script type="text/javascript">
    
//    let browseFile = $('#input_multifileSelect2');
//    let resumable = new Resumable({
//        target: '{{ route('files.upload.large') }}',
//        query:{_token:'{{ csrf_token() }}'} ,// CSRF token
//        fileType: ['mp4','png','jpeg'],
//        headers: {
//            'Accept' : 'application/json'
//        },
//        chunkSize: (15 * 1024 * 1024),
//        forceChunkSize: true,
//        method: "POST",
//        simultaneousUploads: 1,
////        testChunks: false,
//        throttleProgressCallbacks: 1,
//    });
//    
//    resumable.assignBrowse(browseFile[0]);
//
//    resumable.on('fileAdded', function (file) { // trigger when file picked
////        showProgress();
//        resumable.upload() // to actually start uploading.
//    });
//
//    resumable.on('fileProgress', function (file) { // trigger when file progress update
////        alert(resumable.files.length);
////        let per = Math.floor(file.progress() * 100);
////        updateProgress(per);
//    });
//
//    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
////        response = JSON.parse(response)
////        var s3Val = $('#test_name').val()
////        $('#test_name').val(response.path +', '+ s3Val);
//        alert('success');
//        $('#videoPreview').attr('src', response.path);
//        $('.card-footer').show();
//    });
//
//    resumable.on('fileError', function (file, response) { // trigger when there is any error
//        alert(response)
//    });
//
//
//    let progress = $('.progress');
//    function showProgress() {
//        progress.find('.progress-bar').css('width', '0%');
//        progress.find('.progress-bar').html('0%');
//        progress.find('.progress-bar').removeClass('bg-success');
//        progress.show();
//    }
//
//    function updateProgress(value) {
//        progress.find('.progress-bar').css('width', `${value}%`)
//        progress.find('.progress-bar').html(`${value}%`)
//    }
//
//    function hideProgress() {
//        progress.hide();
//    }
    
    
    
    Dropzone.options.myGreatDropzone =
         {
            maxFilesize: 500,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
//            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 0,
            success: function(file, response) 
            {
                var obj = JSON.parse(response);
                const arr = $('#postIds').val();
                if(arr) {
                 $('#postIds').val(arr+','+obj.data);   
                } else {
                 $('#postIds').val(obj.data);   
                }
            },
            error: function(file, response)
            {
               alert(response);
            }
};
    
    var page = 1;

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;
        if (url.indexOf("?") !== -1) {
            var url = window.location.href + '&page=' + page;
        } else {
            var url = window.location.href + '?page=' + page;
        }

        $.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function () {
                $('.ajax-load').show();
            }
        })
                .done(function (data) {
                    if (data.html == "") {
                        $('.ajax-load').addClass('requests');
                        $('.ajax-load').html("No more records found");
                        return;
                    }

                    $('.ajax-load').removeClass('requests');
                    $('.ajax-load').hide();
                    $("#search-data").append(data.html);
                });
    }
</script>
@endsection
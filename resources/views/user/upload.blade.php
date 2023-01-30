@extends('layouts.user.new_layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<style>
 
</style>
<section class="home-section">

    <div class="container">
        <div class="home-row">

            @include('layouts.user.left_sidebar')    

            <div class="middle-content">
                <form method="POST" name="createPostForm" action="{{ route('storeVideoImagePost') }}" class="upload-form" enctype="multipart/form-data">
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
                            <input type="hidden" name="imagesHid_input[]" id="imagesHid_input" >
                            <input type="hidden" name="videosHid_input[]" id="videosHid_input" >
                            <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id ?? ''}}">

                            <div class="multiple-photo-upload">
                                <div class=" align-items-start d-flex flex-wrap gap-4">
                                    <div class="upload-photo-multiple" >
                                        <div>
                                            <img src="img/blue-upload-large.png">
                                            <span>Drag files to<br>upload</span>
                                        </div>
                                        <button class="blue-btn btn">CHOOSE FILE</button>
                                        <input type="file" id="input_multifile" name="files[]" multiple="multiple">
                                    </div>
                                    <div class="upload-file-name" id="filesInfo">
                                    </div>
                                </div>
                            </div>
                            <!-- <div id="app">  
                                <file-uploader  
                                        :unlimited="true"  
                                        collection="avatars"  
                                        name="media"  
                                        :tokens="{{ json_encode(old('media', [])) }}"  
                                        label="Upload Avatar"  
                                        notes="Supported types: jpeg, png,jpg,gif"
                                        :display-validation-messages="true"  
                                ></file-uploader>  
                            </div>  -->
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
                            </div>
                            <div class="row">

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
                                        <label class="col-md-4">Fin Set Up</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="fin_set_up">
                                                <option value="">{{ __('-- Select --')}}</option>
                                                @foreach($customArray['fin_set_up'] as $key => $value)
                                                <option value="{{ $key }}"
                                                        {{ old('fin_set_up') == $key ? "selected" : "" }}>{{ $value}}
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
                                        <label class="col-md-4">Stance</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" name="stance">
                                                <option value="">{{ __('-- Select --')}}</option>
                                                <option value="GOOFY">Goofy</option>
                                                <option value="REGULAR">Regular</option>
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
                                        <label class="col-md-4">Board Type</label>
                                        <div class="col-md-8">
                                            <select class="form-select ps-2 mb-0" id="board_type" name="board_type">
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
                            <div class="row d-none" id="additional_optional_info">

                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-10">
                                <button id="formSubmit" class="btn blue-btn w-150" type="submit">UPLOAD</button>
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

<script src="https://sdk.amazonaws.com/js/aws-sdk-2.828.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/laravel-file-uploader"></script>  
<script>
//   new Vue({  
//     el: '#app'  
//   })  
</script> 
<script type="text/javascript">

    

//    var bucketName = 'surfhub';
//    var bucketRegion = 'ap-southeast-2';
//    var IdentityPoolId = 'ap-southeast-2:8cbd8e79-bff8-488e-ab00-d580948e68e7';
//    AWS.config.update({
//        region: bucketRegion,
//        credentials: new AWS.CognitoIdentityCredentials({
//            IdentityPoolId: IdentityPoolId
//        })
//    });
////
//    var s3 = new AWS.S3({
//        apiVersion: '2006-03-01',
////        httpOptions: {timeout: 0},
//        params: {Bucket: bucketName},
//    });
//    var opts = {queueSize: 1, partSize: 1024 * 1024 * 10};

//    $(document).on('change', '#input_multifile', function () {
//        var files = document.getElementById('input_multifile').files;
//        var len = files.length;
//       
//        
//        for (var i = 0; i < len; i++) {
//            var ext = files[i].name.substring(files[i].name.lastIndexOf(".") + 1).toLowerCase();
////        uploadFiles(files[i],ext);
//            var random = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;
//            var user_id = $('#user_id').val();
//            var timeStamp = Date.now() + ""+ random;
//            var fileName = timeStamp +'.' + ext;
//            if (ext == "png" || ext == "jpeg" || ext == "jpg") {
//
//                imgElems.push(fileName);
//                $("<div id='progress" + timeStamp + "' class='px-4'></div>").insertAfter(".target" + i);
//                var filePath = 'images/' + user_id + '/' + fileName;
//            } else {
//                var filePath = 'videos/' + user_id + '/' + fileName;
//                vidElems.push(fileName);
//                $("<div id='progress" + timeStamp + "' class='px-4'></div>").insertAfter(".target" + i);
//            }
//            var fileUrl = 'https://d1d39qm6rlhacy.cloudfront.net/' + filePath;
////    alert(fileUrl);
////            s3.upload({
////                Key: filePath,
////                Body: files[i],
//////        ACL: 'public-read'
////            }, opts,  function (err, data) {
////                if (err) {
////                    alert(err);
////                }
////                console.log('Successfully Uploaded!' + data);
////                $('#imagesHid_input').val(JSON.stringify(imgElems));
////                $('#videosHid_input').val(JSON.stringify(vidElems));
////            }).on('httpUploadProgress', function (progress) {
////                const key = progress.key.split("/");
////                const check = key[2].split(".");
////                console.log(check);
////                var uploaded = parseInt((progress.loaded * 100) / progress.total) + '%';
////                $("#progress" + check[0]).html(uploaded);
////
////            });
//
//
//                $.ajax({
//                url: presignedUrl, // the presigned URL
//                type: 'PUT',
//                data: 'data to upload into URL',
//                success: function() { console.log('Uploaded data successfully.'); }
//              });
//
//
//
//        }
//    });


</script>
@endsection
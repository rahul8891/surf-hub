$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    /**
     * resetForm Form  validator on close     
     * remove image preview on close (pip)
     */

    $("#file_button").click(function () {
        $("input[name='files[]']").trigger("click");
    });

    $("#video_button").click(function () {
        $("input[name='videos[]']").trigger("click");
    });

    $("input[name='files[]']").on("change", function () {
        if (parseInt($("input[name='files[]']").get(0).files.length) > 50) {
            alert("You can select only 10 images");
            $(this).val('');
        }
    });

    $("input[name='videos[]']").on("change", function () {
        if (parseInt($("input[name='videos[]']").get(0).files.length) > 50) {
            alert("You can select only 10 videos");
            $(this).val('');
        }
    });


    $(".close").click(function (e) {
        var validator = $("#postForm").validate();
        validator.resetForm();
        $('.pip').remove();
    });

    // get application base url
    var base_url = window.location.origin;
    /**************************************************************************************
     *               Manage Image
     *************************************************************************************/
    var dataImage = new Array();
    var dataVideo = new Array();

    $("#input_multifileSelect1").change(function () {
        readImageURL(this);
    });

    $("#input_multifileSelect2").change(function () {
        readVideoURL(this);
    });

    $("#input_multifile").change(function () {
        previewFile(this);
    });

    function previewFile(input) {
        var newFileList = Array.from(input.files);
        var fLen = 0;
        $.each(newFileList, function (index, mediaFile) {
            var ext = mediaFile.name.substring(mediaFile.name.lastIndexOf(".") + 1).toLowerCase();
            if (mediaFile && (ext == "mov" || ext == "mp4" || ext == "wmv" || ext == "mkv" || ext == "gif" || ext == "mpeg4")) {
                $("#videoError").hide();
                var f = newFileList[index]
                dataVideo.push(input.files[index]);
                fLen = (dataVideo.length) - 1;
                var _size = f.size;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                        i = 0;
                while (_size > 900) {
                    _size /= 1024;
                    i++;
                }
                var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];

                $("#filesInfo").append('<div class="name-row pip"><img src="/img/video-upload.png"><span>' + mediaFile.name + ' ' + exactSize + '</span><a class="remove-photo target' + fLen + '" data-index=' + index + '> &#x2715;</a></div>');
                $(".remove-photo").click(function () {
                    var indexRemoved = $(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    $(this).parent(".pip").remove();
                });
            }
            if (mediaFile && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var f = newFileList[index]
                dataVideo.push(input.files[index]);
                fLen = (dataVideo.length) - 1;
                var _size = f.size;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                        i = 0;
                while (_size > 900) {
                    _size /= 1024;
                    i++;
                }
                var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];

                $("#filesInfo").append('<div class="name-row pip"><img src="/img/img-upload.png"><span>' + mediaFile.name + ' ' + exactSize + '</span><a class="remove-photo target' + fLen + '" data-index=' + index + '> &#x2715;</a></div>');
                $(".remove-photo").click(function () {
                    var indexRemoved = $(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    $(this).parent(".pip").remove();
                });
            }
            if (newFileList.length == 0) {
                $("#videoError").show();
            }
        });
    }
    function readVideoURL(input) {
        var newFileList = Array.from(input.files);
        $.each(newFileList, function (index, videoFile) {
            var ext = videoFile.name.substring(videoFile.name.lastIndexOf(".") + 1).toLowerCase();
            if (videoFile && (ext == "mov" || ext == "mp4" || ext == "wmv" || ext == "mkv" || ext == "gif" || ext == "mpeg4")) {
                $("#videoError").hide();
                var f = newFileList[index]
                dataVideo.push(input.files[index]);

                //var filename = Math.round((new Date()).getTime() / 1000) + "." + ext;               

                //$("#input_multifile2").val(filename);

                //storeFiles(videoFile, filename);

                $("<span class=\"pip\">" +
                        "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"/img/play.png\" title=\"" + videoFile.name + "\"/>" +
                        "<br/><span class=\"remove\" data-index=\"" + index + "\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                        "</span>").insertAfter("#filesInfo");
                $(".remove").click(function () {
                    var indexRemoved = $(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    $(this).parent(".pip").remove();
                });
            } else {
                // REMOVE IMAGE INDEX IF NOT IMAGE 
                newFileList.splice(index);
            }
            if (newFileList.length == 0) {
                $("#videoError").show();
            }
        });
    }

    function readImageURL(input) {
        var newFileList = Array.from(input.files);
        $.each(newFileList, function (index, img) {
            var ext = img.name.substring(img.name.lastIndexOf(".") + 1).toLowerCase();
            if (img && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
                $("#imageError").hide();
                var f = newFileList[index]
                dataImage.push(input.files[index]);

                // var filename = Math.round((new Date()).getTime() / 1000) + "." + ext;               

                // $("#input_multifile2").val(filename);

                // storeFiles(videoFile, filename);
                // dataImage[index] = newFileList[index];
                reader = new FileReader();
                reader.onload = (function (e) {
                    var file = e.target;
                    $("<span class=\"pip\">" +
                            "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\" data-index=\"" + index + "\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                            "</span>").insertAfter("#filesInfo");
                    $(".remove").click(function () {
                        var indexRemoved = $(this).data('index');
                        dataImage.splice(indexRemoved, 1);
                        $(this).parent(".pip").remove();
                    });
                });
                reader.readAsDataURL(f);
            } else {
                // REMOVE IMAGE INDEX IF NOT IMAGE 
                newFileList.splice(index);
            }
            if (newFileList.length == 0) {
                $("#imageError").show();
            }
        });

        /*  newFileList = Array.from(input.files);
         $.each(newFileList, function(index, img ) {     
         var ext = img.name.substring(img.name.lastIndexOf(".") + 1).toLowerCase();
         if (img && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
         $("#imageError").hide();
         dataImage[index] = img;
         reader = new FileReader();
         reader.onload = (function (tFile) {
         return function (evt) {
         var div = document.createElement('div');
         div.innerHTML = '<img style="width: 50px;" src="' + evt.target.result + '" /><span id="remove-img" class="removeImg"><img src="http://127.0.0.1:8000/img/close.png" id="img-remove" data-index="'+index+'" style="margin: -13px;position: absolute;top: 187px;cursor: pointer;" width="14px" alt=""></span>';                    
         document.getElementById('filesInfo').appendChild(div);
         };
         }(img));
         reader.readAsDataURL(img);
         }else{
         // REMOVE IMAGE INDEX IF NOT IMAGE 
         newFileList.splice(index);
         }     
         if(newFileList.length == 0){
         $("#imageError").show();
         $('#imagebase64Multi').val('');
         }
         $('#imagebase64Multi').val(newFileList);
         });  */
    }

    /*************************************************************************************/

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

    // no space allow in text box
    /* $.validator.addMethod(
     "noSpace",
     function (value, element) { 
     return value == "" || value.trim().length != 0;
     },
     "No space please and don't leave it empty"
     ); */
    /**
     * Validate post form befor submit
     */
    $("form[name='createPostForm']").validate({
        rules: {
            post_type: {
                required: true,
            },
            post_text: {
                required: false,
                noSpace: true
            },
            surf_date: {
                required: true,
            },
            wave_size: {
                required: true,
            },
            country_id: {
                required: true
            },
            local_beach_break: {
                required: true
            },
            state_id: {
                required: false
            },
            board_type: {
                required: false
            },
            surfer: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.insertAfter(element.parent().parent());
            } else {
                // This is the default behavior of the script for all fields
                error.insertAfter(element);
            }
        },
        messages: {
            post_type: {
                required: "Please select post type"
            },
            post_text: {
                required: "Please enter post text"
            },
            surf_date: {
                required: "Please select surf date"
            },
            wave_size: {
                required: "Please select wave size"
            },
            country_id: {
                required: "Please select your country"
            },
            local_beach_break: {
                required: "Please enter beach break"
            },
            state_id: {
                required: "Please select state"
            },
            board_type: {
                required: "Please select board type"
            },
            surfer: {
                required: "Please select surfer"
            }
        },
        submitHandler: function (form, e) {
//            form.submit();
            // Manage Form Data 
            e.preventDefault();
            $("#input_multifile").val('');
            var formData = new FormData(form);

            console.log(formData);
//            console.log(formData.files);
//            return false;
//            $.each($("#input_multifile"), function (i, obj) {
//                $.each(obj.files, function (j, file) {
//                    formData.append('files[' + i + ']', file); // is the var i against the var j, because the i is incremental the j is ever 0
//                });
//            });
            $.ajax({
                type: "POST",
                url: "/create-post",
//                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function (jsonResponse) {
                    var res = JSON.parse(jsonResponse);
                    alert(res.message);
//                    console.log(jsonResponse);
                    location.reload();
//                    x[0].setAttribute('style', 'display: none !important');
//                    postResult(jsonResponse);
                }
            });
        }
    });

    $("form[name='adminCreatePostForm']").validate({
        rules: {
            post_type: {
                required: true,
            },
            post_text: {
                required: false,
                noSpace: true
            },
            surf_date: {
                required: true,
            },
            wave_size: {
                required: true,
            },
            country_id: {
                required: true
            },
            local_beach_break: {
                required: true
            },
            state_id: {
                required: false
            },
            board_type: {
                required: false
            },
            surfer: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.insertAfter(element.parent().parent());
            } else {
                // This is the default behavior of the script for all fields
                error.insertAfter(element);
            }
        },
        messages: {
            post_type: {
                required: "Please select post type"
            },
            post_text: {
                required: "Please enter post text"
            },
            surf_date: {
                required: "Please select surf date"
            },
            wave_size: {
                required: "Please select wave size"
            },
            country_id: {
                required: "Please select your country"
            },
            local_beach_break: {
                required: "Please enter beach break"
            },
            state_id: {
                required: "Please select state"
            },
            board_type: {
                required: "Please select board type"
            },
            surfer: {
                required: "Please select surfer"
            }
        },
        submitHandler: function (form, e) {
//            form.submit();
            // Manage Form Data 
            e.preventDefault();
            $("#input_multifile").val('');
            var formData = new FormData(form);

            console.log(formData);
//            console.log(formData.files);
//            return false;
//            $.each($("#input_multifile"), function (i, obj) {
//                $.each(obj.files, function (j, file) {
//                    formData.append('files[' + i + ']', file); // is the var i against the var j, because the i is incremental the j is ever 0
//                });
//            });
            $.ajax({
                type: "POST",
                url: "/admin/post/store",
//                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                cache: false,
                contentType: false,
                success: function (jsonResponse) {
                    var res = JSON.parse(jsonResponse);
                    alert(res.message);
//                    console.log(jsonResponse);
                    location.reload();
//                    x[0].setAttribute('style', 'display: none !important');
//                    postResult(jsonResponse);
                }
            });
        }
    });

    function postResult(jsonResponse) {
        if ($.isEmptyObject(jsonResponse.error)) {
            $('.alert-block').css('display', 'block').append('<strong>' + jsonResponse.success + '</strong>');
        } else {
            $.each(jsonResponse.error, function (key, value) {
                $(document).find('[name=' + key + ']').after('<lable class="text-strong textdanger error">' + value + '</lable>');
            });
        }
    }

    /**
     * Manage radio button
     */
    $('input[type=radio]').on('change', function () {
        switch ($(this).val()) {
            case 'Me':
                $("#othersSurfer").hide();
                $("#other_surfer").val("");
                $('.other_surfer').val('');
                break;
            case 'Others':
                $("#othersSurfer").show();
                $("#other_surfer").val("");
                break;
            case 'Unknown':
                $("#othersSurfer").hide();
                $("#other_surfer").val("");
                $('.other_surfer').val('');
                break;
            default:
                $("#othersSurfer").hide();
                $("#other_surfer").val("");
        }
    });

    /************** rating js ****************************/
    $(document).on('change', '.rating', function () {
        var value = $(this).val();
        var id = $(this).attr("data-id");

        if (id != '') {
            var csrf_token = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                type: "POST",
                url: "/rating",
                data: {
                    value: value,
                    id: id,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    $('#average-rating' + id).html(Math.floor(jsonResponse['averageRating']));
                    $('#users-rated' + id).html(Math.floor(jsonResponse['usersRated']));
                    $(".rating-container").hide();
                    $(".rating-container").siblings(".avg-rating").show();

                }
            });
        } else {
            $(this).val(value);
        }
    });

    document.querySelectorAll('.video-js').forEach((i) => {
        if (i) {
            const observer = new IntersectionObserver((entries) => {
                observerCallback(entries, observer, i)
            },
                    {threshold: 1});
            observer.observe(i);
        }
    })

    const observerCallback = (entries, observer, header) => {
        entries.forEach((entry, i) => {
            if (entry.intersectionRatio !== 1 && !entry.paused) {
                entry.target.pause();
            } else {
                entry.target.play();
            }
        });
    };

    $('.tag_user').keyup(debounce(function () {
        // the following function will be executed every half second	

        var post_id = $(this).attr('data-post_id');
        if ($(this).val().length > 1) {
            $.ajax({
                type: "GET",
                url: "/getTagUsers",
                data: {
                    post_id: post_id,
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#tag_user_list' + post_id).html(jsonResponse);
                }
            })
        } else {
            $('#user_id').val('');
            $('#tag_user_list' + post_id).html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    $(document).on('click', '.tagSearch li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");
        var postId = $(this).attr("data-post_id");
        //ajax call to insert data in tag table and also set notification
        $.ajax({
            type: "POST",
            url: "/setTagUsers",
            data: {
                post_id: postId,
                user_id: dataId,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {

                if (jsonResponse.status == 'success') {
                    $('#rowId' + dataId).hide();
                    //$('#tag_user_list'+postId).html("");
                    $('.tag_user').val(value);
                    $('#user_id').val(dataId);
                    //$('#tag_user_list'+postId).html("");
                    $(".scrollWrap").empty();
                    $('.scrollWrap').html(jsonResponse.responsData);
                } else {
                    alert(jsonResponse.message);
                }
                $('#tag_user_list' + postId).html(jsonResponse);
            }
        })
    });
    
    $(document).on('click', '.followPost', function () {
        var $this = $(this);
        var dataId = $(this).data("id");
        var postId = $(this).attr("data-post_id");
        $.ajax({
            type: "POST",
            url: "/follow",
            data: {
                followed_user_id: dataId,
                post_id: postId,
                sataus: 'FOLLOW',
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $this.addClass('clicked');
                    $this.removeClass('followPost');

                    spinner.hide();
                } else {
                    spinner.hide();
                    alert(jsonResponse.message);
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });
    $('#searchFollower').keyup(debounce(function () {
        // the following function will be executed every half second	
        var user_id = $('#user_id').val();
        var keyword = $('#searchFollower').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollwers/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    $('#searchFollowing').keyup(debounce(function () {
        // the following function will be executed every half second	
        var keyword = $('#searchFollowing').val();
        var user_id = $('#user_id').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollowing/" + user_id,
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
    $('#searchFollowRequest').keyup(debounce(function () {
        // the following function will be executed every half second	
        var keyword = $('#searchFollowRequest').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/searchFollowRequest",
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                $('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            $('#local_beach_break_id').val('');
//            $('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)
});
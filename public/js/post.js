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
    
    function storeFiles(file, name) {
        var formData = new FormData();           
        formData.append("file", videoFile);
        formData.append("filename", filename);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : base_url+'/upload/file',
            type : 'POST',
            data : formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success : function() {
                console.log(filename);
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
    $("form[name='postForm']").validate({
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
            spinner.show();
            form.submit();
            // Manage Form Data 
            e.preventDefault();

            var myCheckboxes = $('input[name="optional_info[]"]:checked').map(function () {
                return $(this).val();
            }).get();

            var result = new Array();
            var files = new Array();
            files = $('input[name="files[]"]').map(function () {
                return $(this).val();
            }).get();

            // Updated part
            $.each($('form').serializeArray(), function () {
                result[this.name] = this.value;
            });

            result['optional'] = myCheckboxes;

            $.each(dataImage, function (i, file) {
                result['file-' + i, file]
            });

            $.ajax({
                type: "POST",
                url: "/create-post",
                enctype: 'multipart/form-data',
                data: {
                    formData: result,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    postResult(jsonResponse);
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
});
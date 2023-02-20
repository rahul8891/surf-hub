jQuery(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr('content');

    /**
     * resetForm Form  validator on close     
     * remove image preview on close (pip)
     */

    jQuery("#file_button").click(function () {
        jQuery("input[name='files[]']").trigger("click");
    });

    jQuery("#video_button").click(function () {
        jQuery("input[name='videos[]']").trigger("click");
    });

    jQuery("input[name='files[]']").on("change", function () {
        if (parseInt($("input[name='files[]']").get(0).files.length) > 50) {
            alert("You can select only 10 images");
            jQuery(this).val('');
        }
    });

    jQuery("input[name='videos[]']").on("change", function () {
        if (parseInt($("input[name='videos[]']").get(0).files.length) > 50) {
            alert("You can select only 10 videos");
            jQuery(this).val('');
        }
    });


    jQuery(".close").click(function (e) {
        var validator = jQuery("#postForm").validate();
        validator.resetForm();
        jQuery('.pip').remove();
    });

    // get application base url
    var base_url = window.location.origin;
    /**************************************************************************************
     *               Manage Image
     *************************************************************************************/
    var dataImage = new Array();
    var dataVideo = new Array();

    jQuery("#input_multifileSelect1").change(function () {
        readImageURL(this);
    });

    jQuery("#input_multifileSelect2").change(function () {
        readVideoURL(this);
    });

    jQuery("#input_multifile").change(function () {
        previewFile(this);
    });

    function previewFile(input) {
        var newFileList = Array.from(input.files);
        jQuery.each(newFileList, function (index, mediaFile) {
            var ext = mediaFile.name.substring(mediaFile.name.lastIndexOf(".") + 1).toLowerCase();
            if (mediaFile && (ext == "mov" || ext == "mp4" || ext == "wmv" || ext == "mkv" || ext == "gif" || ext == "mpeg4")) {
                jQuery("#videoError").hide();
                var f = newFileList[index]
                dataVideo.push(input.files[index]);
                
                var _size = f.size;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                i=0;while(_size>900){_size/=1024;i++;}
                var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
                
                jQuery("#filesInfo").append('<div class="name-row pip"><img src="/img/video-upload.png"><span>'+ mediaFile.name +' '+ exactSize +'</span><a class="remove-photo" data-index=' + index + '> &#x2715;</a></div>');
                jQuery(".remove-photo").click(function () {
                    var indexRemoved = jQuery(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    jQuery(this).parent(".pip").remove();
                });
            }
            if(mediaFile && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
              var f = newFileList[index]
                dataVideo.push(input.files[index]);
                
                var _size = f.size;
                var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
                i=0;while(_size>900){_size/=1024;i++;}
                var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
                
                jQuery("#filesInfo").append('<div class="name-row pip"><img src="/img/img-upload.png"><span>'+ mediaFile.name +' '+ exactSize +'</span><a class="remove-photo" data-index=' + index + '> &#x2715;</a></div>');
                jQuery(".remove-photo").click(function () {
                    var indexRemoved = jQuery(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    jQuery(this).parent(".pip").remove();
                });  
            }
            if (newFileList.length == 0) {
                jQuery("#videoError").show();
            }
        });
    }
    function readVideoURL(input) {
        var newFileList = Array.from(input.files);
        jQuery.each(newFileList, function (index, videoFile) {
            var ext = videoFile.name.substring(videoFile.name.lastIndexOf(".") + 1).toLowerCase();
            if (videoFile && (ext == "mov" || ext == "mp4" || ext == "wmv" || ext == "mkv" || ext == "gif" || ext == "mpeg4")) {
                jQuery("#videoError").hide();
                var f = newFileList[index]
                dataVideo.push(input.files[index]);
                
                //var filename = Math.round((new Date()).getTime() / 1000) + "." + ext;               
                
                //$("#input_multifile2").val(filename);
                
                //storeFiles(videoFile, filename);
                
                jQuery("<span class=\"pip\">" +
                "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"/img/play.png\" title=\"" + videoFile.name + "\"/>" +
                "<br/><span class=\"remove\" data-index=\"" + index + "\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                "</span>").insertAfter("#filesInfo");
                jQuery(".remove").click(function () {
                    var indexRemoved = jQuery(this).data('index');
                    dataImage.splice(indexRemoved, 1);
                    jQuery(this).parent(".pip").remove();
                });
            } else {
                // REMOVE IMAGE INDEX IF NOT IMAGE 
                newFileList.splice(index);
            }
            if (newFileList.length == 0) {
                jQuery("#videoError").show();
            }
        });
    }
    
    function storeFiles(file, name) {
        var formData = new FormData();           
        formData.append("file", videoFile);
        formData.append("filename", filename);

        jQuery.ajax({
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
        jQuery.each(newFileList, function (index, img) {
            var ext = img.name.substring(img.name.lastIndexOf(".") + 1).toLowerCase();
            if (img && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
                jQuery("#imageError").hide();
                var f = newFileList[index]
                dataImage.push(input.files[index]);
                
                // var filename = Math.round((new Date()).getTime() / 1000) + "." + ext;               
                
                // $("#input_multifile2").val(filename);
                
                // storeFiles(videoFile, filename);
                // dataImage[index] = newFileList[index];
                reader = new FileReader();
                reader.onload = (function (e) {
                    var file = e.target;
                    jQuery("<span class=\"pip\">" +
                            "<img style=\"width: 50px;\" class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\" data-index=\"" + index + "\"><img src=\"" + base_url + "\/img/close.png\" id=\"remove\" style=\"margin: 0px;position: inherit;padding: 0px 0px 10px 0px;top: 148px;cursor: pointer;\" width=\"14px\"></span>" +
                            "</span>").insertAfter("#filesInfo");
                    jQuery(".remove").click(function () {
                        var indexRemoved = jQuery(this).data('index');
                        dataImage.splice(indexRemoved, 1);
                        jQuery(this).parent(".pip").remove();
                    });
                });
                reader.readAsDataURL(f);
            } else {
                // REMOVE IMAGE INDEX IF NOT IMAGE 
                newFileList.splice(index);
            }
            if (newFileList.length == 0) {
                jQuery("#imageError").show();
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
    jQuery("form[name='postForm']").validate({
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

            var myCheckboxes = jQuery('input[name="optional_info[]"]:checked').map(function () {
                return jQuery(this).val();
            }).get();

            var result = new Array();
            var files = new Array();
            files = jQuery('input[name="files[]"]').map(function () {
                return jQuery(this).val();
            }).get();

            // Updated part
            jQuery.each(jQuery('form').serializeArray(), function () {
                result[this.name] = this.value;
            });

            result['optional'] = myCheckboxes;

            jQuery.each(dataImage, function (i, file) {
                result['file-' + i, file]
            });

            jQuery.ajax({
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
        if (jQuery.isEmptyObject(jsonResponse.error)) {
            jQuery('.alert-block').css('display', 'block').append('<strong>' + jsonResponse.success + '</strong>');
        } else {
            jQuery.each(jsonResponse.error, function (key, value) {
                jQuery(document).find('[name=' + key + ']').after('<lable class="text-strong textdanger error">' + value + '</lable>');
            });
        }
    }

    /**
     * Manage radio button
     */
    jQuery('input[type=radio]').on('change', function () {
        switch (jQuery(this).val()) {
            case 'Me':
                jQuery("#othersSurfer").hide();
                jQuery("#other_surfer").val("");
                jQuery('.other_surfer').val('');
                break;
            case 'Others':
                jQuery("#othersSurfer").show();
                jQuery("#other_surfer").val("");
                break;
            case 'Unknown':
                jQuery("#othersSurfer").hide();
                jQuery("#other_surfer").val("");
                jQuery('.other_surfer').val('');
                break;
            default:
                jQuery("#othersSurfer").hide();
                jQuery("#other_surfer").val("");
        }
    });
    
    /************** rating js ****************************/
    jQuery(document).on('change', '.rating', function () {
        var value = jQuery(this).val();
        var id = jQuery(this).attr("data-id");

        if (id != '') {
            var csrf_token = jQuery('meta[name="csrf-token"]').attr("content");

            jQuery.ajax({
                type: "POST",
                url: "/rating",
                data: {
                    value: value,
                    id: id,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    jQuery('#average-rating' + id).html(Math.floor(jsonResponse['averageRating']));
                    jQuery('#users-rated' + id).html(Math.floor(jsonResponse['usersRated']));
                    jQuery(".rating-container").hide();
                    jQuery(".rating-container").siblings(".avg-rating").show();

                }
            });
        } else {
            jQuery(this).val(value);
        }
    });
    
    
});
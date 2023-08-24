jQuery(document).ready(function () {
    var csrf_token = jQuery('meta[name="csrf-token"]').attr("content");

    /************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";

    // var spinner = jQuery('#loader');

    var spinner = jQuery(".loaderWrap");

    jQuery("#next").click(function (event) {
        spinner.show();
    });

    /**
     hide spiner
     */
    if (stopSpiner) {
        spinner.hide();
    }
    /************** end spiner code ****************************/

    /************************************************************
     *              Admin Update user status
     ***********************************************************/
    jQuery(".changeStatus").on("switchChange.bootstrapSwitch", function (e, data) {
        var currentStatus = data;
        var userId = jQuery(this).data("id");
        spinner.show();
        jQuery.ajax({
            type: "POST",
            url: "updateUserStatus",
            data: {
                user_id: userId,
                status: currentStatus,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    spinner.hide();
                    document.getElementById("error").innerHTML =
                            jsonResponse.message;
                    document.getElementById("error").className =
                            "alert alert-success";
                } else {
                    spinner.hide();
                    document.getElementById("error").innerHTML =
                            jsonResponse.message;
                    document.getElementById("error").className =
                            "alert alert-danger";
                }
                setInterval(myTimerUserMessage, 4000);
            }
        });
    });

    jQuery(document).on('click', '.add-ads', function () {
        var id = jQuery(this).data('id');
        jQuery('#page_id').val(id);

    });

    jQuery(document).on('change', '#filter_country_id, #edit_country_id', function (e) {
        var currentcountryValue = jQuery(this).val();
        if (currentcountryValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getState',
                data: {
                    country_id: currentcountryValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#filter_state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#filter_state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            jQuery("#filter_state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        jQuery("#filter_state_id").empty();
                    }
                }
            });
        } else {
            jQuery("#filter_state_id").empty();
        }
    });

    jQuery(document).on('click', '.beachbreakmodal', function () {
        var id = jQuery(this).data('id');
        jQuery.ajax({
            url: '/admin/get-beach-break-detail/' + id,
            type: "get",
            async: false,
            success: function (data) {
                // console.log(data.html);
                jQuery("#editBeachBreakModal").html("");
                jQuery("#editBeachBreakModal").append(data.html);
                jQuery("#editBeachBreakModal").modal('show');
            }
        });
    });

    jQuery(document).on('change', '#beach_break_excel', function () {
        var fd = new FormData();

        var files = jQuery('#beach_break_excel')[0].files;
         // Append data
         fd.append('excel_file',files[0]);
         fd.append('_token',csrf_token);
         jQuery('.loadingWrap').removeClass('d-none');
        jQuery.ajax({
            type: "POST",
            url: "/admin/breachbreak/import-excel",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (jsonResponse) {
                // console.log(data.html);
                location.reload();
            }
        });
    });

    jQuery("#exampleInputFile").change(function () {
        readURL(this);
    });


    var $image_crop;
    $image_crop = jQuery('#image').croppie({
        enableExif: true,
        enableOrientation: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    function readURL(input) {

        var url = input.value;
        var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
        if (
                input.files &&
                input.files[0] &&
                (ext == "png" || ext == "jpeg" || ext == "jpg")
                ) {
            jQuery("#imageError").hide();
            var reader = new FileReader();
            reader.onload = function (e) {
                $image_crop.croppie('bind', {
                    url: e.target.result
                }).then(function (blob) {
                    // console.log(blob);
                });
            };
            reader.readAsDataURL(input.files[0]);
            jQuery('#myModal').modal('show');
            jQuery("#remove-img").show();
            jQuery("form[name='register-surfer'] #remove-img").show();
            jQuery("form[name='register-resort'] #remove-img").show();
            jQuery("form[name='register-advertiser'] #remove-img").show();
        } else {
            jQuery('#imagebase64').val("");
            jQuery("form[name='register-surfer'] #imagebase64").val("");
            jQuery("form[name='register-resort'] #imagebase64").val("");
            jQuery("form[name='register-advertiser'] #imagebase64").val("");
            jQuery("#exampleInputFile").val("");
            jQuery("form[name='register-surfer'] #exampleInputFile").val("");
            jQuery("form[name='register-resort'] #exampleInputFile").val("");
            jQuery("form[name='register-advertiser'] #exampleInputFile").val("");

            jQuery("#category-img-tag").attr("src", "/img/image-file.png");
            jQuery("#category-img-tag").attr("width", "auto");


            jQuery("form[name='register-surfer'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-surfer'] #category-img-tag").attr("width", "auto");

            jQuery("form[name='register-resort'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-resort'] #category-img-tag").attr("width", "auto");

            jQuery("form[name='register-advertiser'] #category-img-tag").attr("src", "/img/image-file.png");
            jQuery("form[name='register-advertiser'] #category-img-tag").attr("width", "auto");

            jQuery("#remove-img").hide();
            jQuery("#imageError").show();
            jQuery("form[name='register-surfer'] #remove-img").hide();
            jQuery("form[name='register-resort'] #remove-img").hide();
            jQuery("form[name='register-advertiser'] #remove-img").hide();
            jQuery("form[name='register-surfer'] #imageError").show();
            jQuery("form[name='register-resort'] #imageError").show();
            jQuery("form[name='register-advertiser'] #imageError").show();
        }
    }
    jQuery('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            jQuery('#imagebase64').val(response);
            jQuery("form[name='register-surfer'] #imagebase64").val(response);
            jQuery("form[name='register-resort'] #imagebase64").val(response);
            jQuery("form[name='register-advertiser'] #imagebase64").val(response);
            jQuery("#category-img-tag").attr("src", response);
            jQuery("#category-img-tag").attr("width", "100%");

            jQuery("form[name='register-surfer'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-surfer'] #category-img-tag").attr("width", "100%");

            jQuery("form[name='register-resort'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-resort'] #category-img-tag").attr("width", "100%");

            jQuery("form[name='register-advertiser'] #category-img-tag").attr("src", response);
            jQuery("form[name='register-advertiser'] #category-img-tag").attr("width", "100%");

            jQuery('#myModal').modal('hide');
        })
    });

    /**
     * Model Cancle
     */
    jQuery(".close").click(function () {
        jQuery('#imagebase64').val("");
        jQuery("form[name='register-surfer'] #imagebase64").val("");
        jQuery("form[name='register-resort'] #imagebase64").val("");
        jQuery("form[name='register-advertiser'] #imagebase64").val("");
        jQuery("#exampleInputFile").val("");
        jQuery("form[name='register-surfer'] #exampleInputFile").val("");
        jQuery("form[name='register-resort'] #exampleInputFile").val("");
        jQuery("form[name='register-advertiser'] #exampleInputFile").val("");
        jQuery("#category-img-tag").attr("src", "");
        jQuery("#category-img-tag").attr("src", "img/image-file.png");
        jQuery("#category-img-tag").attr("width", "auto");
        jQuery("#remove-img").hide();
    });
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
    // ajax form field data for post
    jQuery('.search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 2) {
            jQuery.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    jQuery('#country_list').html(jsonResponse);
                }
            })

        } else {
            jQuery('#local_beach_break_id').val('');
            jQuery('#country_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    jQuery(document).on('click', '.search1 li', function () {
        var value = jQuery(this).text();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#country_list').html("");
        jQuery('.search-box').val(value);
        jQuery('#local_beach_break_id').val(dataId);
        getBreak(dataId);
        jQuery('#country_list').html("");
    });


    function getBreak(beachValue) {
//        var beachValue = jQuery(this).val();
        if (beachValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getBreak',
                data: {
                    beach_id: beachValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#break_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#break_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            if (value.break_name != '') {
                                jQuery("#break_id").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                                jQuery("#break_id").rules("add", {required: true, messages: {required: "Break is required"}});

                            } else {
                                jQuery("#break_id").rules("remove");
                            }
                        });
                    } else {
                        jQuery("#break_id").empty();
                    }
                }
            });
        } else {
            jQuery("#state_id").empty();
        }
    }

    jQuery('.other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        if (jQuery(this).val().length > 1) {
            jQuery.ajax({
                type: "GET",
                url: "/getUsers",
                data: {
                    searchTerm: jQuery(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    jQuery('#other_surfer_list').html(jsonResponse);
                }
            })
        } else {
            jQuery('#surfer_id').val('');
            jQuery('#other_surfer_list').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    jQuery(document).on('click', '.search2 li', function () {
        var value = jQuery(this).text().trim();
        var dataId = jQuery(this).attr("data-id");
        jQuery('#other_surfer_list').html("");
        jQuery('.other_surfer').val(value);
        jQuery('#surfer_id').val(dataId);
        jQuery('#other_surfer_list').html("");
    });

    /**
     * State Baded on the selection on country
     */

    jQuery(document).on('change', '#country_id, #edit_country_id', function (e) {
        var currentcountryValue = jQuery(this).val();
        if (currentcountryValue != 0) {
            jQuery.ajax({
                type: "GET",
                url: '/getState',
                data: {
                    country_id: currentcountryValue,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
                    if (jsonResponse.status == 'success') {
                        jQuery("#state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        jQuery("#state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        jQuery.each(myJsonData, function (key, value) {
                            jQuery("#state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        jQuery("#state_id").empty();
                    }
                }
            });
        } else {
            jQuery("#state_id").empty();
        }
    });

    jQuery("#board_type").change(function (e) {
//    if (jQuery('#beach_filter').is(":selected")) {
//        jQuery('#break_filter').find('option').remove();
//        jQuery("#break_filter").append('<option value=""> -- Break --</option>');
        var board_type = jQuery(this).val();
        if (board_type !== '') {
            jQuery.ajax({
                type: "GET",
                url: '/get-additional-board-info',
                data: {
                    board_type: board_type,
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    //console.log(jsonResponse);
//                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;

                    jQuery('#additional_optional_info').removeClass('d-none');
                    jQuery('#additional_optional_info').html(jsonResponse);
//                } else {
//                    jQuery('#additional_optional_info').addClass('d-none');
//                }
                }
            });

        } else {
            jQuery('#additional_optional_info').addClass('d-none');
//        jQuery("#break_filter").remove();
        }
    });


    /* Beach Break Location Popup */
function initializeMap(lat, long) {
    var map;
    var geocoder;
    var latlng = new google.maps.LatLng(lat, long);
    var myOptions =
            {
                zoom: 14,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
                },
                scrollwheel: false,
                navigationControl: false,
                scaleControl: false,
                disableDoubleClickZoom: true,
                zoomControl: true,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.RIGHT_TOP,
                },
            };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    new google.maps.Marker({
        position: latlng,
        map: map
    });

}
    //show map on modal
jQuery(document).on('click shown.bs.modal', '.locationMap', function () {
    var id = jQuery(this).attr("data-id");
    var lat = jQuery(this).attr("data-lat");
    var long = jQuery(this).attr("data-long");
    jQuery("#beachLocationModal").modal('show');
    initializeMap(lat, long);
});

jQuery('#searchReports').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = jQuery('#searchReports').val();
//        if (jQuery(this).val().length > 2) {
        jQuery.ajax({
            type: "GET",
            url: "/admin/report/search",
            data: {
                searchTerm: keyword,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                jQuery('.list-followers').html(jsonResponse.html);
            }
        })

//        } else {
//            jQuery('#local_beach_break_id').val('');
//            jQuery('#country_list').html("");
//        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    /* jQuery('.add-to-feed').click(function () {
        let status =  1;
        let postId = jQuery(this).data('id');
        jQuery.ajax({
            type: "GET",
            dataType: "json",
            url: "/admin/post/feed-post",
            data: {'status': status, 'post_id': postId},
            success: function (data) {
                if(data.statuscode == 200) {
                    jQuery(".addFeed"+postId).remove();
                    jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Feed has been added successfully.</div>');
                } else {
                    jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Something went wrong. Please try again later.</div>');
                }
                console.log(data.message);
            }
        });
    }); */

    $('.add-to-feed').click(function () {
        let status =  1;
        let postId = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/admin/post/feed-post",
            data: {'status': status, 'post_id': postId},
            success: function (data) {
                if(data.statuscode == 200) {
                    $(".addFeed"+postId).remove();
                    jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Feed has been added successfully.</div>');
                } else {
                    jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Something went wrong. Please try again later.</div>');
                }
                console.log(data.message);
            }
        });
    });

    jQuery('.remove-from-feed').click(function () {
            let status =  0;
            let postId = jQuery(this).data('id');
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "/admin/post/status",
                data: {'status': status, 'post_id': postId},
                success: function (data) {
                    if(data.statuscode == 200) {
                        jQuery(".myPostData"+postId).remove();
                        jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Feed has been deleted successfully.</div>');
                    } else {
                        jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Something went wrong. Please try again later.</div>');
                    }
                    console.log(data.message);
                }
            });
        });

        jQuery('.filter_username').keyup(debounce(function () {
            // the following function will be executed every half second
            var userType = jQuery('#filter_user_type').val();

            if (jQuery(this).val().length > 1) {
                jQuery.ajax({
                    type: "POST",
                    url: "/getFilterUsernames",
                    data: {
                        user_type: userType,
                        searchTerm: jQuery(this).val(),
                        _token: csrf_token
                    },
                    dataType: "json",
                    success: function (jsonResponse) {
                        jQuery('#filter_username_data').html(jsonResponse);
                    }
                });
            } else {
                jQuery('#username_id_filter').val('');
                jQuery('#filter_username_data').html("");
            }
        }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

        jQuery(document).on('click', '#filter_username_data li', function () {
            var value = jQuery(this).text().trim();
            var dataId = jQuery(this).attr("data-id");

            jQuery('.filter_username').val(value);
            jQuery('#username_id_filter').val(dataId);
            jQuery('#filter_username_data').html("");
        });

        // no space allow in text box
    jQuery.validator.addMethod(
        "noSpace",
        function (value, element) {
            return value == "" || value.trim().length != 0;
        },
        "No space please and don't leave it empty"
    );


    jQuery("#beach_filter").change(function (e) {
        jQuery('#break_filter').find('option').remove();
        jQuery("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = jQuery(this).val();
        jQuery.ajax({
            type: "GET",
            url: '/getBreak',
            data: {
                beach_id: beachValue,
                _token: csrf_token
            },
            dataType: "json",
            success: function (jsonResponse) {
                //console.log(jsonResponse);
                if (jsonResponse.status == 'success') {
                    var myJsonData = jsonResponse.data;

                    jQuery.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            jQuery("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                        }
                    });
                }
            }
        });
    });
});
/**
 * remove message after time set hit
 */
function myTimerUserMessage() {
    document.getElementById("error").innerHTML = "";
    document.getElementById("error").className = "";
}






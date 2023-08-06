$(document).ready(function () {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");

    /************** spiner code ****************************/
    var stopSpiner = "{{ $spiner}}";

    // var spinner = $('#loader');

    var spinner = $(".loaderWrap");

    $("#next").click(function (event) {
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
    $(".changeStatus").on("switchChange.bootstrapSwitch", function (e, data) {
        var currentStatus = data;
        var userId = $(this).data("id");
        spinner.show();
        $.ajax({
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

    $(document).on('click', '.add-ads', function () {
        var id = $(this).data('id');
        $('#page_id').val(id);

    });

    $(document).on('change', '#filter_country_id, #edit_country_id', function (e) {
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
            $.ajax({
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
                        $("#filter_state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#filter_state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            $("#filter_state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        $("#filter_state_id").empty();
                    }
                }
            });
        } else {
            $("#filter_state_id").empty();
        }
    });
    $(document).on('click', '.beachbreakmodal', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/get-beach-break-detail/' + id,
            type: "get",
            async: false,
            success: function (data) {
                // console.log(data.html);
                $("#editBeachBreakModal").html("");
                $("#editBeachBreakModal").append(data.html);
                $("#editBeachBreakModal").modal('show');
            }
        });
    });

    $(document).on('change', '#beach_break_excel', function () {
        var fd = new FormData();

        var files = $('#beach_break_excel')[0].files;
         // Append data
         fd.append('excel_file',files[0]);
         fd.append('_token',csrf_token);
         $('.loadingWrap').removeClass('d-none');
        $.ajax({
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

    $("#exampleInputFile").change(function () {
        readURL(this);
    });


    var $image_crop;
    $image_crop = $('#image').croppie({
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
            $("#imageError").hide();
            var reader = new FileReader();
            reader.onload = function (e) {
                $image_crop.croppie('bind', {
                    url: e.target.result
                }).then(function (blob) {
                    // console.log(blob);
                });
            };
            reader.readAsDataURL(input.files[0]);
            $('#myModal').modal('show');
            $("#remove-img").show();
            $("form[name='register-surfer'] #remove-img").show();
            $("form[name='register-resort'] #remove-img").show();
            $("form[name='register-advertiser'] #remove-img").show();
        } else {
            $('#imagebase64').val("");
            $("form[name='register-surfer'] #imagebase64").val("");
            $("form[name='register-resort'] #imagebase64").val("");
            $("form[name='register-advertiser'] #imagebase64").val("");
            $("#exampleInputFile").val("");
            $("form[name='register-surfer'] #exampleInputFile").val("");
            $("form[name='register-resort'] #exampleInputFile").val("");
            $("form[name='register-advertiser'] #exampleInputFile").val("");

            $("#category-img-tag").attr("src", "/img/image-file.png");
            $("#category-img-tag").attr("width", "auto");


            $("form[name='register-surfer'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-surfer'] #category-img-tag").attr("width", "auto");

            $("form[name='register-resort'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-resort'] #category-img-tag").attr("width", "auto");

            $("form[name='register-advertiser'] #category-img-tag").attr("src", "/img/image-file.png");
            $("form[name='register-advertiser'] #category-img-tag").attr("width", "auto");

            $("#remove-img").hide();
            $("#imageError").show();
            $("form[name='register-surfer'] #remove-img").hide();
            $("form[name='register-resort'] #remove-img").hide();
            $("form[name='register-advertiser'] #remove-img").hide();
            $("form[name='register-surfer'] #imageError").show();
            $("form[name='register-resort'] #imageError").show();
            $("form[name='register-advertiser'] #imageError").show();
        }
    }
    $('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $('#imagebase64').val(response);
            $("form[name='register-surfer'] #imagebase64").val(response);
            $("form[name='register-resort'] #imagebase64").val(response);
            $("form[name='register-advertiser'] #imagebase64").val(response);
            $("#category-img-tag").attr("src", response);
            $("#category-img-tag").attr("width", "100%");

            $("form[name='register-surfer'] #category-img-tag").attr("src", response);
            $("form[name='register-surfer'] #category-img-tag").attr("width", "100%");

            $("form[name='register-resort'] #category-img-tag").attr("src", response);
            $("form[name='register-resort'] #category-img-tag").attr("width", "100%");

            $("form[name='register-advertiser'] #category-img-tag").attr("src", response);
            $("form[name='register-advertiser'] #category-img-tag").attr("width", "100%");

            $('#myModal').modal('hide');
        })
    });

    /**
     * Model Cancle
     */
    $(".close").click(function () {
        $('#imagebase64').val("");
        $("form[name='register-surfer'] #imagebase64").val("");
        $("form[name='register-resort'] #imagebase64").val("");
        $("form[name='register-advertiser'] #imagebase64").val("");
        $("#exampleInputFile").val("");
        $("form[name='register-surfer'] #exampleInputFile").val("");
        $("form[name='register-resort'] #exampleInputFile").val("");
        $("form[name='register-advertiser'] #exampleInputFile").val("");
        $("#category-img-tag").attr("src", "");
        $("#category-img-tag").attr("src", "img/image-file.png");
        $("#category-img-tag").attr("width", "auto");
        $("#remove-img").hide();
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
    $('.search-box').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 2) {
            $.ajax({
                type: "GET",
                url: "/getBeachBreach",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {

                    $('#country_list').html(jsonResponse);
                }
            })

        } else {
            $('#local_beach_break_id').val('');
            $('#country_list').html("");
        }

    }, 100)); // Milliseconds in which the ajax call should be executed (500 = half second)

    $(document).on('click', '.search1 li', function () {
        var value = $(this).text();
        var dataId = $(this).attr("data-id");
        $('#country_list').html("");
        $('.search-box').val(value);
        $('#local_beach_break_id').val(dataId);
        getBreak(dataId);
        $('#country_list').html("");
    });
    function getBreak(beachValue) {
//        var beachValue = $(this).val();
        if (beachValue != 0) {
            $.ajax({
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
                        $("#break_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#break_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            if (value.break_name != '') {
                                $("#break_id").append('<option value="' + value.id + '">' + value.break_name + '</option>');
                                $("#break_id").rules("add", {required: true, messages: {required: "Break is required"}});

                            } else {
                                $("#break_id").rules("remove");
                            }
                        });
                    } else {
                        $("#break_id").empty();
                    }
                }
            });
        } else {
            $("#state_id").empty();
        }
    }

    $('.other_surfer').keyup(debounce(function () {
        // the following function will be executed every half second
        if ($(this).val().length > 1) {
            $.ajax({
                type: "GET",
                url: "/getUsers",
                data: {
                    searchTerm: $(this).val(),
                    _token: csrf_token
                },
                dataType: "json",
                success: function (jsonResponse) {
                    $('#other_surfer_list').html(jsonResponse);
                }
            })
        } else {
            $('#surfer_id').val('');
            $('#other_surfer_list').html("");
        }
    }, 100)); // Milliseconds in which the ajax call should be executed (100 = half second)

    $(document).on('click', '.search2 li', function () {
        var value = $(this).text().trim();
        var dataId = $(this).attr("data-id");
        $('#other_surfer_list').html("");
        $('.other_surfer').val(value);
        $('#surfer_id').val(dataId);
        $('#other_surfer_list').html("");
    });

    /**
     * State Baded on the selection on country
     */

    $(document).on('change', '#country_id, #edit_country_id', function (e) {
        var currentcountryValue = $(this).val();
        if (currentcountryValue != 0) {
            $.ajax({
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
                        $("#state_id, #edit_state_id").empty();
                        var myJsonData = jsonResponse.data;
                        $("#state_id, #edit_state_id").append('<option value="">--Select--</option>');
                        $.each(myJsonData, function (key, value) {
                            $("#state_id, #edit_state_id").append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    } else {
                        $("#state_id").empty();
                    }
                }
            });
        } else {
            $("#state_id").empty();
        }
    });

    $("#board_type").change(function (e) {
//    if ($('#beach_filter').is(":selected")) {
//        $('#break_filter').find('option').remove();
//        $("#break_filter").append('<option value=""> -- Break --</option>');
        var board_type = $(this).val();
        if (board_type !== '') {
            $.ajax({
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

                    $('#additional_optional_info').removeClass('d-none');
                    $('#additional_optional_info').html(jsonResponse);
//                } else {
//                    $('#additional_optional_info').addClass('d-none');
//                }
                }
            });

        } else {
            $('#additional_optional_info').addClass('d-none');
//        $("#break_filter").remove();
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
$(document).on('click shown.bs.modal', '.locationMap', function () {
    var id = $(this).attr("data-id");
    var lat = $(this).attr("data-lat");
    var long = $(this).attr("data-long");
    initializeMap(lat, long);
});

$('#searchReports').keyup(debounce(function () {
        // the following function will be executed every half second
        var keyword = $('#searchReports').val();
//        if ($(this).val().length > 2) {
        $.ajax({
            type: "GET",
            url: "/admin/report/search",
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

    $('.add-to-feed').click(function () {
            let status =  1;
            let postId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/admin/post/status",
                data: {'status': status, 'post_id': postId},
                success: function (data) {
                    if(data.statuscode == 200) {
                        $("#errorSuccessmsg").removeClass('alert-danger');
                        $("#errorSuccessmsg").addClass('alert-success');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                    } else {
                        $("#errorSuccessmsg").removeClass('alert-success');
                        $("#errorSuccessmsg").addClass('alert-danger');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                    }
                    console.log(data.message);
                }
            });
        });
    $('.remove-from-feed').click(function () {
            let status =  0;
            let postId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/admin/post/status",
                data: {'status': status, 'post_id': postId},
                success: function (data) {
                    if(data.statuscode == 200) {
                        $("#errorSuccessmsg").removeClass('alert-danger');
                        $("#errorSuccessmsg").addClass('alert-success');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                    } else {
                        $("#errorSuccessmsg").removeClass('alert-success');
                        $("#errorSuccessmsg").addClass('alert-danger');
                        $("#errorSuccessmsg").append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                    }
                    console.log(data.message);
                }
            });
        });

    $("#beach_filter").change(function (e) {
        $('#break_filter').find('option').remove();
        $("#break_filter").append('<option value=""> -- Break --</option>');
        var beachValue = $(this).val();
        $.ajax({
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

                    $.each(myJsonData, function (key, value) {
                        if (value.break_name != '') {
                            $("#break_filter").append('<option value="' + value.id + '">' + value.break_name + '</option>');
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



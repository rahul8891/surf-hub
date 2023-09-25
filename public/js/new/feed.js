var page = 1;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= ($(document).height() - 10)) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;
        if(url.indexOf("?") !== -1) {
            var url = window.location.href + '&page=' + page;
        }else {
            var url = window.location.href + '?page=' + page;
        }

        $.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function() {
                $('.ajax-load').show();
            }
        })
        .done(function(data) {
            if(data.html == "") {
                $('.ajax-load').addClass('requests');
                $('.ajax-load').html("No more records found");
                return;
            }

            $('.ajax-load').removeClass('requests');
            $('.ajax-load').hide();
    //            $("#post-data").insertBefore(data.html);
            $(data.html).insertBefore(".ajax-load");
        });
    }

    //Auto play videos when view in scroll
    function isInView(el) {
        var rect = el.getBoundingClientRect();// absolute position of video element
        return !(rect.top > (jQuery(window).height() / 2) || rect.bottom < (jQuery(window).height() / 4));// visible?
    }

    jQuery(document).on("scroll", function () {
        jQuery("video").each(function () { //console.log('aa');
            // jQuery("video").get(0).pause();
            // visible?
            if (isInView(jQuery(this).get(0))) { // console.log('video = '+ jQuery.parseJSON(jQuery(this).get(0).paused));
                if (jQuery(this).get(0).paused) { //console.log('1111');
                    jQuery(this).get(0).play(true);// play if not playing
                }
            } else {
                if (!jQuery(this).get(0).paused) { //console.log('2222');
                    jQuery(this).get(0).pause();// pause if not paused
                }
           }
        });
    });
    //End auto play

    function surferRequestDetail(id) {
        jQuery.ajax({
            url: 'surfer-request/' + id,
            type: "get",
            async: false,
            success: function() {
                jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Surfer Request sent successfully.</div>');
            }
        });
    }

    function reportSubmit(id) {
        var info = '';
        var content = '';
        var troll = '';

        if($("#incorrectInfo"+id).is(':checked')) {
            info = $("#incorrectInfo"+id).val();
        }

        if($("#incorrectContent"+id).is(':checked')) {
            content = $("#incorrectContent"+id).val();
        }

        if($("#reportTrolls"+id).is(':checked')) {
            troll = $("#reportTrolls"+id).val();
        }

        var formData = {
            post_id: id,
            incorrect: info,
            inappropriate: content,
            tolls: troll,
            comments: $("#comments"+id).val(),
        };

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'report',
            type: "post",
            data: formData,
            async: false,
            success: function(data) {
                data = $.parseJSON(data);

                if(data.status == 'success') {
                    jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }else {
                    jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }
            }
        });

        return false;
    }

    function deleteSaveUserPost(id, type) {
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/'+type+'/'+id,
            type: "GET",
            async: false,
            success: function(data) {
                data = $.parseJSON(data);

                if(data.status == 'success') {
                    $(".feed"+id).remove();
                    jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }else {
                    jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }
            }
        });

        return false;
    }

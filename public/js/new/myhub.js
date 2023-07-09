var page = 1;

jQuery(window).scroll(function() {
    if(jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()) {alert('bb');
        page++;
        loadMoreData(page);
    } else {
        alert('ccc');
    }
});

function loadMoreData(page) { alert('aaa');
    var url = window.location.href;
    if(url.indexOf("?") !== -1) {
        var url = window.location.href + '&page=' + page;
    }else {
        var url = window.location.href + '?page=' + page;
    }
    
    jQuery.ajax({
        url: url,
        type: "get",
        async: false,
        beforeSend: function() {
            jQuery('.ajax-load').show();
        }
    })
    .done(function(data) {
        if(data.html == "") {
            jQuery('.ajax-load').addClass('requests');
            jQuery('.ajax-load').html("No more records found");
            return;
        }

        jQuery('.ajax-load').removeClass('requests');
        jQuery('.ajax-load').hide();
        jQuery(data.html).insertBefore(".ajax-load");
    });
}
     
/*jQuery('.left-navbar-toggler').on('click', function (e) {
    jQuery('body').toggleClass('overflow-hidden');
    jQuery('.my-details-div').toggleClass('menu-slideIn');
});*/

jQuery('.left-navbar-toggler').on('click', function (e) {
    console.log("testing002");
    e.stopPropagation();
    jQuery('body').toggleClass('overflow-hidden');
    jQuery('.my-details-div').toggleClass('menu-slideIn');
});



    jQuery(document).on('click', function (){
        console.log("testing003");
        if(jQuery('.my-details-div').hasClass('menu-slideIn')) {
            jQuery('.my-details-div').toggleClass('menu-slideIn');
        }
    });


jQuery(document).on('click', '.rating-flex-child', function (e) {
  jQuery(this).children(".rating-container").show();
  jQuery(this).children(".avg-rating").hide();
});

//jQuery(document).on('click', '.rating-stars', function (e) {
//  jQuery(this).parents(".rating-container").hide();
//  jQuery(this).parents(".rating-container").siblings(".avg-rating").show();
//});

jQuery(document).ready(function() {

    jQuery('.slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
      });


   jQuery('.modal').on('shown.bs.modal', function (e) {
    jQuery('.slider').slick('setPosition');
    // jQuery('.wrap-modal-slider').addClass('open');
  })
});



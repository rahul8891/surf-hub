$('.left-navbar-toggler').on('click', function (e) {
    $('body').toggleClass('overflow-hidden');
    $('.my-details-div').toggleClass('menu-slideIn');
});

$(document).on('click', '.rating-flex-child', function (e) {
  $(this).children(".rating-container").show();
  $(this).children(".avg-rating").hide();
});

//$(document).on('click', '.rating-stars', function (e) {
//  $(this).parents(".rating-container").hide();
//  $(this).parents(".rating-container").siblings(".avg-rating").show();
//});

$(document).ready(function() { 
    
    $('.slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
      });
   
   
   $('.modal').on('shown.bs.modal', function (e) {
    $('.slider').slick('setPosition');
    // $('.wrap-modal-slider').addClass('open');
  })
});



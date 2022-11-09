$('.left-navbar-toggler').on('click', function (e) {
    $('body').toggleClass('overflow-hidden');
    $('.my-details-div').toggleClass('menu-slideIn');
});


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
jQuery('.left-navbar-toggler').on('click', function (e) {
  jQuery('body').toggleClass('overflow-hidden');
  jQuery('.my-details-div').toggleClass('menu-slideIn');
});

jQuery(".avg-rating").click(function(){
  jQuery(".rating-container").show(2500);
});

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
  });
});


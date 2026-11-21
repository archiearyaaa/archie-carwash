(function ($) {
  "use strict";

  // PRE LOADER
  $(window).load(function(){
    $('.preloader').fadeOut(600);    
  });

  // Navigation auto-collapse on mobile after clicking a link
  $('.navbar-collapse a').on('click', function(){
    if (!$(this).hasClass('dropdown-toggle')) {
      $(".navbar-collapse").collapse('hide');
    }
  });

  // Owl Carousel Hero Slider
  if ($('.owl-carousel').length > 0) {
    $('.owl-carousel').owlCarousel({
      animateOut: 'fadeOut',
      items: 1,
      loop: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      dots: true,
      nav: false,
      mouseDrag: false,
      touchDrag: true
    });
  }

  // PARALLAX EFFECT (Only on desktop to prevent mobile scroll glitch)
  if (window.innerWidth > 768 && typeof $.fn.stellar === 'function') {
    $.stellar({
      horizontalScrolling: false,
      responsive: true
    });
  }

  // SMOOTHSCROLL (Only for internal anchor links starting with #)
  $(function() {
    $('a.smoothScroll, .navbar-default a[href^="#"], #home a[href^="#"], footer a[href^="#"]').on('click', function(event) {
      var targetHref = $(this).attr('href');
      if (targetHref && targetHref.charAt(0) === '#' && targetHref.length > 1) {
        var $target = $(targetHref);
        if ($target.length) {
          event.preventDefault();
          var offsetTop = (targetHref === '#home' || targetHref === '#top') ? 0 : ($target.offset().top - 70);
          $('html, body').stop().animate({
            scrollTop: offsetTop
          }, 600);
        }
      }
    });
  });  

  // WOW ANIMATION
  if (typeof WOW === 'function') {
    new WOW({ mobile: false }).init();
  }

})(jQuery);

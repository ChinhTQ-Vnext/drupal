(function ($, Drupal) {
    Drupal.behaviors.pickupSwiper = {
      attach: function (context, settings) {
        if (!context.querySelector('.pickup-swiper-initialized')) {
          const swiper = new Swiper('.pickup-swiper', {
            direction: 'vertical',
            slidesPerView: 6,
            slidesPerGroup: 1,
            loop: true,
            loopedSlides: 5, // Đảm bảo hoạt động mượt với 8 slides
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          });
  
          $('.pickup-swiper', context).addClass('pickup-swiper-initialized');
        }
      }
    };
  })(jQuery, Drupal);
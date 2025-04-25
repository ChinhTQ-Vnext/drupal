(function ($, Drupal) {
    Drupal.behaviors.swiperInit = {
        attach: function (context, settings) {
            const thumbSlider = new Swiper('.thumb-slider', {
                spaceBetween: 10,
                slidesPerView: 4,
                freeMode: true,
                watchSlidesProgress: true,
            });

            const mainSlider = new Swiper('.main-slider', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: thumbSlider,
                },
            });
        }
    };
})(jQuery, Drupal);
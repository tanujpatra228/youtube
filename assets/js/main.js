/**
 * IWS Woo Extension - 1.0.0
 */
jQuery(document).ready(function(){
    var swiper = new Swiper(".iws-swiper", {
        slidesPerView: 2,
        spaceBetween: 10,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            575: {
                slidesPerView: 2
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 4
            },
        }
    });
});
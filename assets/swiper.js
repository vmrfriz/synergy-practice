document.addEventListener('DOMContentLoaded', function () {
    new Swiper(".mySwiper", {
        effect: 'fade',
        allowTouchMove: false,
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        pagination: {
            el: '.slide-info',
            type: 'fraction',
        },
    });
});

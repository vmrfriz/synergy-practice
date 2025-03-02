class Slider {
    constructor(selector) {
        this.element = document.querySelector(selector);
        this.slides = [...this.element.querySelectorAll('.slider-wrapper .slide')];
        this.prevButtons = [...this.element.querySelectorAll('.slide-prev')];
        this.nextButtons = [...this.element.querySelectorAll('.slide-next')];
        this.counter = [...this.element.querySelectorAll('.slide-info')];

        this.#initEvents();
        this.updateCounter();
        this.activeSlide = 0;
        this.showSlide(this.activeSlide);
    }
    #initEvents() {
        this.prevButtons.forEach(item => item.addEventListener('click', this.prevSlide.bind(this)));
        this.nextButtons.forEach(item => item.addEventListener('click', this.nextSlide.bind(this)));
    }
    updateCounter() {
        this.counter.forEach(item => {
            item.innerHTML = `${this.activeSlide + 1} / ${this.slides.length}`;
        });
    }
    showSlide(index) {
        let slides = document.querySelectorAll('.slide');
        slides[this.activeSlide].classList.remove('active');
        slides[index].classList.add('active');
        this.activeSlide = index;
        this.updateCounter();
    }
    nextSlide() {
        this.showSlide((this.activeSlide + 1) % this.slides.length);
    }
    prevSlide() {
        this.showSlide((this.activeSlide - 1 + this.slides.length) % this.slides.length);
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const slider1 = new Slider('#first-slider');
    // let info = document.querySelectorAll('.slide-info');

    // info.forEach((item) => {
    //     let slidesCount = slider.querySelectorAll('.slider-wrapper.slide').length;
    //     let currentSlideIndex = 
    // });
});

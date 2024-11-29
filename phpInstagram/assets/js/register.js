const carousel = document.getElementById('imageCarousel');
const slides = carousel.getElementsByTagName('img');
const totalSlides = slides.length;
let currentSlide = 0;

function showSlide(slideIndex) {
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } else if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }

    // Disable the current slide
    slides[currentSlide].classList.remove('active');

    // Enable the next slide
    slides[slideIndex].classList.add('active');

    currentSlide = slideIndex;
}

function autoSlide() {
    showSlide(currentSlide + 1);
}

// Change slide automatically every 3 seconds
setInterval(autoSlide, 3000);

// Show the initial slide
showSlide(currentSlide);

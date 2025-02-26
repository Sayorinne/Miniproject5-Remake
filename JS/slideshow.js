let slideIndex = 0;
let timeoutId = null;
const slides = document.getElementsByClassName("mySlides");
const dots = document.getElementsByClassName("dot");

// Ensure the showSlides function is called when the page loads
document.addEventListener("DOMContentLoaded", function() {
    showSlides();
});

function currentSlide(index) {
    slideIndex = index;
    showSlides();
}

function plusSlides(step) {
    if (step < 0) {
        slideIndex--;

        if (slideIndex < 0) {
            slideIndex = slides.length - 1;
        }
    } else {
        slideIndex++;
        if (slideIndex >= slides.length) {
            slideIndex = 0;
        }
    }
    showSlides();
}

function showSlides() {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        dots[i].classList.remove('active');
    }
    slides[slideIndex].style.display = "block";
    dots[slideIndex].classList.add('active');
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => plusSlides(1), 5000); // Change image every 5 seconds
}
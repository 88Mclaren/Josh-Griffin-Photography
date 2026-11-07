
/* PHOTO CAROUSEL */

let currentSlide = 0;

const slides = document.querySelectorAll(".slide");

function showSlide(index) {

    if (slides.length === 0) return;

    slides[currentSlide].classList.remove("active");

    currentSlide = (index + slides.length) % slides.length;

    slides[currentSlide].classList.add("active");
}


// Previous and Next Buttons

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}


// Automatically change slides every 4 seconds

if (slides.length > 1) {
    setInterval(function() {
        showSlide(currentSlide + 1);
    }, 4000);
}


/* PORTFOLIO DROPDOWN */

const dropdown = document.querySelector(".dropdown");
const dropButton = document.querySelector(".dropbtn");

if (dropdown && dropButton) {

    dropButton.addEventListener("click", function(event) {

        event.stopPropagation();

        dropdown.classList.toggle("show");

    });


    // Close dropdown when clicking outside

    document.addEventListener("click", function(event) {

        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove("show");
        }

    });

}

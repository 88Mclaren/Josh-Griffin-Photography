
const menuToggle = document.getElementById("menuToggle");
const navbar = document.getElementById("navbar");

// Open and close mobile navigation
menuToggle.addEventListener("click", () => {

    const isOpen = navbar.classList.toggle("active");

    menuToggle.setAttribute("aria-expanded", isOpen);

    menuToggle.setAttribute(
        "aria-label",
        isOpen ? "Close navigation menu" : "Open navigation menu"
    );

    menuToggle.textContent = isOpen ? "✕" : "☰";

});

// Close navigation after selecting a link
navbar.querySelectorAll("a").forEach(link => {

    link.addEventListener("click", () => {

        navbar.classList.remove("active");

        menuToggle.setAttribute("aria-expanded", "false");

        menuToggle.setAttribute(
            "aria-label",
            "Open navigation menu"
        );

        menuToggle.textContent = "☰";

    });

});

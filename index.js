function prevTestimonial() {
    document.querySelector('.testimonials-container').scrollBy({ left: -350, behavior: 'smooth' });
}

function nextTestimonial() {
    document.querySelector('.testimonials-container').scrollBy({ left: 350, behavior: 'smooth' });
}
document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".scroll-animation");

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            } else {
                entry.target.classList.remove("active"); // Repeats the animation on every scroll
            }
        });
    }, { threshold: 0.2 });

    images.forEach(image => observer.observe(image));
});

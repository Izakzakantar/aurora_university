function prevTestimonial() {
    document.querySelector('.testimonials-container').scrollBy({ left: -350, behavior: 'smooth' });
}

function nextTestimonial() {
    document.querySelector('.testimonials-container').scrollBy({ left: 350, behavior: 'smooth' });
}

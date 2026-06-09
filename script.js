document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('admin-view')) {
        initCharts();
    }
});

// ==========================================
// HERO CAROUSEL LOGIC
// ==========================================
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
let slideInterval;

function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    
    if (index >= slides.length) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = slides.length - 1;
    } else {
        currentSlide = index;
    }
    
    slides[currentSlide].classList.add('active');
}

function moveCarousel(step) {
    showSlide(currentSlide + step);
    resetInterval();
}

function startCarousel() {
    slideInterval = setInterval(() => {
        moveCarousel(1);
    }, 5000); // Change image every 5 seconds
}

function resetInterval() {
    clearInterval(slideInterval);
    startCarousel();
}

// Initialize Carousel
if (slides.length > 0) {
    startCarousel();
}

// ==========================================
// ADMIN DASHBOARD LOGIC
// ==========================================

function toggleSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const mainWrapper = document.getElementById('main-wrapper');
    
    // Check if mobile
    if (window.innerWidth <= 768) {
        sidebar.classList.toggle('mobile-open');
    } else {
        sidebar.classList.toggle('collapsed');
        mainWrapper.classList.toggle('expanded');
    }
}




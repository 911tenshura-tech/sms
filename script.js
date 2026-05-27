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

// Global Alert Function
function showAlert(message) {
    alert(message);
}

// ==========================================
// CHART.JS INITIALIZATION
// ==========================================
let attendanceChartInstance = null;
let resultsChartInstance = null;

function initCharts() {
    // Destroy existing charts if they exist to prevent overlap
    if(attendanceChartInstance) attendanceChartInstance.destroy();
    if(resultsChartInstance) resultsChartInstance.destroy();

    // 1. Attendance Doughnut Chart
    const ctxAttendance = document.getElementById('attendanceChart');
    if (ctxAttendance) {
        attendanceChartInstance = new Chart(ctxAttendance, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    data: [85, 10, 5],
                    backgroundColor: [
                        '#28a745', // Success green
                        '#dc3545', // Danger red
                        '#ffc107'  // Warning yellow
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter', size: 12 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // 2. Examination Results Bar Chart
    const ctxResults = document.getElementById('resultsChart');
    if (ctxResults) {
        resultsChartInstance = new Chart(ctxResults, {
            type: 'bar',
            data: {
                labels: ['Term 1', 'Term 2', 'Term 3'],
                datasets: [
                    {
                        label: 'Science',
                        data: [75, 82, 88],
                        backgroundColor: '#1e56b3',
                        borderRadius: 5
                    },
                    {
                        label: 'Maths',
                        data: [68, 75, 85],
                        backgroundColor: '#fca311',
                        borderRadius: 5
                    },
                    {
                        label: 'English',
                        data: [80, 85, 82],
                        backgroundColor: '#28a745',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { family: 'Inter' } }
                    }
                }
            }
        });
    }
}
// Weather Widget Script and API connection
async function getWeather() {
    const apiKey = "263d2ae9ae61acc7be2a3f810c57a314";
    const city = "mmss weather";
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

    try {
        const response = await fetch(url);
        
        // Handle API errors gracefully (like a 401 or 404)
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log("API Response Data:", data);

        const temp = Math.round(data.main.temp);
        const weather = data.weather[0].main;

        // Default icon
        let icon = "fa-cloud-sun";

        // Change icon according to weather
        if(weather === "Rain") {
            icon = "fa-cloud-rain";
        }
        else if(weather === "Clouds") {
            icon = "fa-cloud";
        }
        else if(weather === "Clear") {
            icon = "fa-sun";
        }

        // Update HTML
        document.getElementById("weather").innerHTML = 
        `<i class="fa-solid ${icon}"></i> ${temp}°C, ${weather}`;
        
        console.log("Weather data fetched and DOM updated successfully.");

    } catch(error) {
        console.error("Weather Widget Error:", error);
        document.getElementById("weather").innerText = "Weather unavailable";
    }
}

// Run the function exactly once on page load
getWeather();
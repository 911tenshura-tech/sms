<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resources - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="public-view" class="view active-view">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="contact-info">
                <i class="fa-solid fa-phone"></i> +977 9999999999
            </div>
            <div class="contact-info">
                <i class="fa-solid fa-envelope"></i> info@mahendramaheshdev.edu.np
            </div>
        <div class="weather-info" id="weather">
                Loading weather...
        </div>

        </div>
 
        </div>

        <!-- Navbar -->
        <nav class="navbar">
            <a href="index.php">
                <div class="logo-container">
                    <img src="assets/logo.png" alt="Logo" class="logo-img">
                    <div class="logo-text">
                        <h1>Mahendra Maheshdev</h1>
                        <p>Secondary School</p>
                    </div>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
                <li><a href="team.php">Team</a></li>
                <li><a href="notices.php" class="active">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="public-main">
            <section class="page-header"
                style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Notices and Results</h2>
                <p style="font-size: 1.1rem; color: #666;">Access school resources, notices, and results.</p>
            </section>
        </main>

        <div class="fees-section" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
            <h3>Pay Fees Online</h3>
            <p>Make your fee payments conveniently through our online portal.</p> <br> 
            <a href="fees.php" class="btn" style="text-decoration: underline; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Pay Now</a>
        </div>

        <!-- Footer -->
        <footer class="public-footer">
            <div class="footer-grid">
                <div class="principal-message">
                    <img src="assets/principal.jpg" alt="Principal" class="principal-img">
                    <div class="message-content">
                        <h3>Message from the Principal</h3>
                        <p>"At Mahendra Maheshdev, we believe in empowering students with knowledge, skills, and values.
                            Our dedicated team is committed to creating a vibrant learning community where every child
                            can thrive and achieve their full potential."</p>
                        <h4>- Madan Shrestha</h4>
                    </div>
                </div>
                <div class="featured-gallery">
                    <h3>Featured Gallery</h3>
                    <div class="gallery-grid">
                        <div class="gallery-img" style="background-image: url('assets/gallery_1.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/gallery_2.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/gallery_3.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/carousel_2.jpg');"></div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Our location: <a href="https://maps.app.goo.gl/SxXacD9EYP2rnC787">Google Maps</a></p><br>
            <h3>Quick Links</h3>
            <ul class="quick_links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
                <li><a href="team.php">Team</a></li>
                <li><a href="notices.php">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
                <p>&copy; 2026 Mahendra Maheshdev Secondary School, Likhu Rural Municipality Ward no. 6, Nuwakot, Nepal.
                    All Rights Reserved.</p>
                <div class="portal-link">
                   <a href="login.php"><i class="fa-solid fa-user-lock"></i> Admin Portal</a>
                </div>
            </div>
        </footer>
    </div>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>
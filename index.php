<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahendra Maheshdev Secondary School</title>
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

    <!-- ========================================== -->
    <!-- PUBLIC HOME PAGE VIEW                      -->



        <div class="top-bar">
            <div class="contact-info">
                <i class="fa-solid fa-phone"></i> +977 9999999999
            </div>
            <div class="contact-info">
                <i class="fa-solid fa-envelope"></i> info@mahendramaheshdev.edu.np
            </div>
        <div class="date-info" id="date">
                <?php
                //date time logic
                    date_default_timezone_set('Asia/Kathmandu');

                    echo date('F j, Y g:i a'); 

                ?>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
                <li><a href="team.php">Team</a></li>
                <li><a href="notices.php">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Hero Carousel Section -->
        <section class="hero">
            <div class="carousel-container">
                <div class="carousel-slide active" style="background-image: url('assets/school1.png');"></div>
                <div class="carousel-slide" style="background-image: url('assets/assembly.jpg');"></div>
                <div class="carousel-slide" style="background-image: url('assets/scouts.jpg');"></div>
                <div class="carousel-slide" style="background-image: url('assets/school1.jpg');"></div>

                <div class="carousel-overlay">
                    <h2>Welcome to Mahendra Maheshdev Secondary School, Likhu-6, Nuwakot</h2>
                    <p>Educating Minds, Building Futures</p>
                    <p>Computer Engineering</p>
                    
                </div>

                <button class="carousel-control prev" onclick="moveCarousel(-1)"><i
                        class="fa-solid fa-chevron-left"></i></button>
                <button class="carousel-control next" onclick="moveCarousel(1)"><i
                        class="fa-solid fa-chevron-right"></i></button>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="public-main">
            <div class="three-column-grid">

                <!-- Latest News -->
                <div class="grid-card news-card">
                    <h3><i class="fa-regular fa-newspaper"></i> Latest News & Notices</h3>
                    <ul class="event-list">
                      
                        <li>
                            <div class="event-date"><span class="day">  <?php
                                $currentDateTime = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));

                                    // Outputs something like: June 9
                                    echo $currentDateTime->format('j');
                                    ?></span><span class="month">May</span></div>
                            <div class="event-details">
                                <h4>Term-End Exam Schedule</h4>
                                <p>Examinations begin for all secondary classes.</p>
                            </div>
                        </li>
                        <!-- <li>
                            <div class="event-date"><span class="day">05</span><span class="month">Jun</span></div>
                            <div class="event-details">
                                <h4>Environment Day Celebration</h4>
                                <p>Tree planting program at school premises.</p>
                            </div>
                        </li> -->
                    </ul>
                </div>

                <!-- Academic Programs -->
                <div class="grid-card programs-card">
                    <h3><i class="fa-solid fa-book-open"></i> Academic Programs</h3>
                    <div class="program-item">
                        <div class="program-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div class="program-info">
                            <h4>Secondary Level</h4>
                            <p>Classes 8 to 10 focusing on holistic foundational growth.</p>
                            <button class="outline-btn" ><a href="admissions.php">Apply
                                Now</a></button>
                        </div>
                    </div>
                    <div class="program-item">
                        <div class="program-icon"><i class="fa-solid fa-computer"></i></div>
                        <div class="program-info">
                            <h4>Technical and Vocational Education</h4>
                            <p>Classes 9-12 Computer Engineering Course.</p>
                            <button class="outline-btn"> <a href="admissions.php">Apply
                                Now</a></button>
                        </div>
                    </div>
                    <div class="program-item">
                        <div class="program-icon"><i class="fa-solid fa-microscope"></i></div>
                        <div class="program-info">
                            <h4>Upper Secondary Level</h4>
                            <p>Classes 11 & 12 offering Management, Computer Science, and
                                Education.</p>
                            <button class="outline-btn" ><a href="admissions.php">Apply
                                Now</a></button>
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us -->
                <div class="grid-card why-us-card">
                    <h3><i class="fa-solid fa-star"></i> Why Choose Us?</h3>
                    <ul class="bullet-list">
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Technical and Vocational
                                Education:</strong> One of the best Technical and Vocational Education provider in the
                            region for Computer Engineernig.</li>
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Quality Education:</strong> Experienced
                            faculty and modern teaching methods.</li>
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Holistic Development:</strong> Focus on
                            sports, arts, and extracurricular activities.</li>
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Modern Facilities:</strong> Well-equipped
                            science & computer labs.</li>
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Safe Environment:</strong> Secure campus
                            with CCTV surveillance.</li>
                        <li><i class="fa-solid fa-check-circle"></i> <strong>Library Access:</strong> Extensive
                            collection of physical and digital resources.</li>
                    </ul>
                </div>
            </div>
        </main>


        <!-- //Management Committee members -->
        <section>
            <div class="public-main">
                <div class="management"> 
                    <center><h1 style="color: black;">Meet Our Honorable School Management Committee Members</h1></center><br>
                    <div class="management-grid three-column-grid ">
                        <div class="management-card grid-card">
                            <img src="assets/sbmc-1.jpg" alt="Management" class="management-img">
                            <div class="management-info">   
                                <h3>Prachanda Bhakta Shrestha</h3>
                                <p>(Chairperson)</p>
                                 <p>Address: <span style="color: rgb(13, 13, 167);">Likhu-6, Nuwakot</span></p>
                                <p>Contact: <span style="color: rgb(13, 13, 167);">9841000000</span></p>
                            </div>
                        </div>
                        <div class="management-card grid-card">
                            <img src="assets/sbmc-2.jpg" alt="Management" class="management-img">
                            <div class="management-info">   
                                <h3>Management Member</h3>
                                <p>(Vice Chairperson)</p>
                                 <p>Address: <span style="color: rgb(13, 13, 167);">Likhu-6, Nuwakot</span></p>
                                <p>Contact: <span style="color: rgb(13, 13, 167);">9841000000</span></p>
                            </div>
                        </div>
                        <div class="management-card grid-card">
                            <img src="assets/sbmc-3.jpg" alt="Management" class="management-img">
                            <div class="management-info">   
                                <h3>Management Member</h3>
                                <p>(Member)</p>
                                 <p>Address: <span style="color: rgb(13, 13, 167);">Likhu-6, Nuwakot</span></p>
                                <p>Contact: <span style="color: rgb(13, 13, 167);">9841000000</span></p>
                            </div>
                        </div>
                        <div class="management-card grid-card">
                            <img src="assets/sbmc-4.jpg" alt="Management" class="management-img">
                            <div class="management-info">   
                                <h3>Management Member</h3>
                                <p>(Member)</p>
                                <p>Address: <span style="color: rgb(13, 13, 167);">Likhu-6, Nuwakot</span></p>
                                <p>Contact: <span style="color: rgb(13, 13, 167);">9841000000</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
        </section>
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
                    <div class="gallery-img" style="background-image: url('assets/school1.jpg');"></div>
                    <div class="gallery-img" style="background-image: url('assets/school2.jpg');"></div>
                    <div class="gallery-img" style="background-image: url('assets/parents.jpg');"></div>
                    <div class="gallery-img" style="background-image: url('assets/assembly.jpg');"></div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-grid">
                <div class="google-location">
                    <p>Our location: <a href="https://maps.app.goo.gl/SxXacD9EYP2rnC787">Google Maps</a></p><br>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7054.615015229879!2d85.261621!3d27.8618227!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eadfed10e8b92b%3A0xcc6d99b369602366!2sMahendra%20Maheshdev%20secondary%20school!5e0!3m2!1sen!2snp!4v1780984074643!5m2!1sen!2snp"
                        width="200" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="quick-links">

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


                        <div class="portal-link">
                            <a href="login.php"><i class="fa-solid fa-user-lock"></i> Admin Portal</a>
                        </div>
                </div>
                </ul>
            </div>
            <p>&copy; 2026 Mahendra Maheshdev Secondary School, Likhu Rural Municipality Ward no. 6, Nuwakot, Nepal.
                All Rights Reserved.</p>

        </div>
    </footer>
    </div>


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="script.js">
 
    </script>
    
</body>

</html>
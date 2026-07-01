<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academics - Mahendra Maheshdev Secondary School</title>
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
          <div class="date-info" id="date">
                <?php
                //date time logic
                    date_default_timezone_set('Asia/Kathmandu');

                    echo date('F j, Y ');  

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
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php" class="active">Academics</a></li>
                <li><a href="team.php">Team</a></li>
                <li><a href="notices.php">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Main Content Area -->
        <main class="public-main">
            <section class="page-header"
                style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Academics</h2>
                <p style="font-size: 1.1rem; color: #666;">Explore our curriculum and educational programs.</p>
            </section>
        </main>
        <div class="academic-info" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
            <h3 style="font-size: 1.8rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Curriculum Overview</h3>
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 2rem;">At Mahendra Maheshdev Secondary School, we offer a comprehensive curriculum that follows the national education standards of Nepal. Our curriculum is designed to foster critical thinking, creativity, and holistic development in our students.</p>
            <h4 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Educational Programs</h4>
            <ul style="list-style-type: disc; padding-left: 20px; color: #666;">
                <li>Education Stream (Grades 11-12)</li>
                <li>Management Stream (Grades 11-12)</li>
                <li>Technical and Vocationa Stream (Grades 9-12)</li>
                <li>Computer Science and IT Courses</li>
                <li>Extracurricular Activities and Clubs</li>
            </ul><br>
            <h3 style="font-size: 1.8rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Students Code of Conduct Overview</h3>
            <ul style="list-style-type: disc; padding-left: 20px; color: #666;">
                <li>Punctuality and Attendance:
                    <ul style="list-style-type: circle; padding-left: 20px; color: #666;">
                        <li>Morning Assembly: Students must arrive at school at least 10 to 15 minutes before the daily national anthem and morning assembly (Prarthana) begins.</li>
                        <li>Regular Attendance: Students must maintain a minimum of 75% attendance to qualify for final examinations.</li>
                        <li>Leave of Absence: If a student is absent, they must submit a leave application signed by their parent or guardian. Unexcused absence for more than a week may result in disciplinary action.</li>
                    </ul>
                </li><br>
                <li>Uniform and Personal Hygiene</li>
                <ul>
                    <li>Dress Code: Students must wear the designated school uniform neatly every day. This typically includes the specified shirt, trousers/skirt, school tie, belt, and black
                         shoes. Special tracksuits are mandatory on designated sports/PT days</li>
                    <li>Grooming: Hair must be clean, neat, and kept to a natural color. Boys should maintain short hair,
                         and girls with long hair should keep it braided or tied neatly.</li>
                    <li>Hygiene and Adornments: Nails must be clipped short. Wearing expensive jewelry, makeup, or fancy 
                        selectronic gadgets (like smartwatches or mobile phones) is strictly prohibited.</li>
                </ul><br>
                <li>Classroom Etiquette and Academic Honesty</li>
                <ul style="list-style-type: circle; padding-left: 20px; color: #666;">
                    <li>Respect for Teachers: Students must stand up to greet teachers and guests when they enter or leave the classroom. Disrespectful behavior or back-talk is not tolerated.</li>
                    <li>Peer Interaction: Students should use polite and respectful language with peers. Using abusive words or teasing is forbidden.</li>
                    <li>Exam Integrity: Cheating, copying, or bringing unauthorized materials into examination halls will result in immediate disqualification from the exam.</li>
                </ul><br>
            </ul>
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
                            <a href="admin/login.php"><i class="fa-solid fa-user-lock"></i> Admin Portal</a>
                        </div>
                </div>
                </ul>
            </div>
            <p>&copy; 2026 Mahendra Maheshdev Secondary School, Likhu Rural Municipality Ward no. 6, Nuwakot, Nepal.
                All Rights Reserved.</p>

        </div>
    </footer>
    </div>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>
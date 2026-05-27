<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-header h1 {
            margin-bottom: 0.5rem;
            color: var(--primary-color, #2c3e50);
        }
        .form-header p {
            color: #666;
        }
        .form-section {
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--primary-color, #2c3e50);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .radio-checkbox-group {
            display: flex;
            gap: 1rem;
        }
        .radio-checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .declaration-box {
            background-color: #f9f9f9;
            padding: 1rem;
            border-left: 4px solid var(--primary-color, #2c3e50);
            margin-bottom: 1.5rem;
        }
        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .btn-container button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-container button[type="reset"] {
            background-color: #ccc;
            color: #333;
        }
        </style>
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


            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php" class="active">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
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
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Admissions
                </h2>
                <p style="font-size: 1.1rem; color: #666;">Join us! Find all admission details here.</p>
            </section>
        </main>
    <div class="admission_info" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">

    <h2 style="font-size: 1.8rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Admission Information</h2>
    <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">Welcome to the admissions page of Mahendra Maheshdev Secondary School! We are excited to welcome new students to our vibrant learning community. Below you will find all the necessary information about our admission process, requirements, and how to apply.</p>
    <h3 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Admission Process</h3>
    <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">Our admission process is designed to be straightforward and transparent. We encourage prospective students and their families to visit our campus, meet our faculty, and learn about our programs before applying. The application process typically involves submitting an application form, providing necessary documents, and attending an interview or entrance exam if required.</p>
    <h3 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Admission Requirements</h3>
    <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">To be eligible for admission to Mahendra Maheshdev Secondary School, 
        applicants must meet the following requirements:</p>
    <ul style="list-style-type: disc; padding-left: 20px; color: #666; margin-bottom: 1.5rem;">
        <li>Completed application form</li>
        <li>Copy of birth certificate</li>
        <li>Previous academic records (if applicable)</li>
        <li>Passport-sized photographs</li>
        <li>Proof of residence</li>
        <li>Medical certificate (if required)</li>
    </ul>
    <h3 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">How to Apply</h3>
    <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">To apply for admission, please follow these steps:</p>
    <ol style="list-style-type: decimal; padding-left: 20px; color: #666; margin-bottom: 1.5rem;">
        <li>Download the application form from our website or collect it from our admissions office.</li>
        <li>Fill out the application form completely and accurately. The given student information should match with his/her birth certificate information</li>
        <li>Gather all required documents as listed in the admission requirements.</li>
        <li>Submit the completed application form along with the required documents to our admissions office by the specified deadline.</li>
        <li>Attend any required interviews or entrance exams as scheduled.</li>
        <li>Wait for the admission decision, which will be communicated to you via email or phone.</li>
    </ol>
    <p style="font-size: 1.1rem; color: #666; margin-bottom: 1.5rem;">Or you can apply for admission online through our website. From the given links, select the "Online Admission Form" option to fill out the form
    and submit it online. Our admissions team will review your application and contact you for further steps.</p>

    <a style="text-decoration: underline; color: #007bff;" href="student_admissions.php">Online Admission form</a>
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
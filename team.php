<?php
require_once 'connection/db.php';
$teachers = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM teachers ORDER BY created_at DESC");
        $stmt->execute();
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $teachers = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .teachers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 40px 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .teacher-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .teacher-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }
        .teacher-image-wrapper {
            position: relative;
            height: 240px;
            background-color: #f0f3f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .teacher-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .teacher-card:hover .teacher-image {
            transform: scale(1.05);
        }
        .teacher-placeholder-icon {
            font-size: 5rem;
            color: #ccd5df;
        }
        .teacher-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .teacher-info h3 {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 700;
        }
        .teacher-role {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--success-color);
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }
        .teacher-role.inactive {
            color: var(--danger-color);
        }
        .teacher-role.on-leave {
            color: var(--warning-color);
        }
        .teacher-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--text-muted);
            border-top: 1px solid #f0f3f6;
            padding-top: 15px;
            margin-top: auto;
        }
        .teacher-details span {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .teacher-details i {
            color: var(--primary-color);
            width: 16px;
        }
        .no-teachers {
            text-align: center;
            padding: 3rem;
            grid-column: 1 / -1;
            color: var(--text-muted);
            font-size: 1.1rem;
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
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
                <li><a href="team.php" class="active">Team</a></li>
                <li><a href="notices.php">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <main class="public-main">
            <section class="page-header"
                style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Team</h2>
                <p style="font-size: 1.1rem; color: #666;">Meet our dedicated teachers and staff.</p>
            </section>

            <div class="teachers-grid">
                <?php if (empty($teachers)): ?>
                    <div class="no-teachers">
                        <i class="fa-solid fa-user-slash" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        No teachers found in the database.
                    </div>
                <?php else: ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <div class="teacher-card">
                            <div class="teacher-image-wrapper">
                                <?php if (!empty($teacher['t_image']) && file_exists('assets/uploads/teachers/' . $teacher['t_image'])): ?>
                                    <img src="assets/uploads/teachers/<?php echo htmlspecialchars($teacher['t_image']); ?>" alt="<?php echo htmlspecialchars($teacher['t_firstname'] . ' ' . $teacher['t_lastname']); ?>" class="teacher-image">
                                <?php else: ?>
                                    <i class="fa-solid fa-chalkboard-user teacher-placeholder-icon"></i>
                                <?php endif; ?>
                            </div>
                            <div class="teacher-info">
                                <h3><?php echo htmlspecialchars($teacher['t_firstname'] . ($teacher['t_midname'] ? ' ' . $teacher['t_midname'] : '') . ' ' . $teacher['t_lastname']); ?></h3>
                                <p class="teacher-role <?php echo strtolower(str_replace(' ', '-', $teacher['t_status'])); ?>">
                                    <?php echo htmlspecialchars($teacher['t_status']); ?>
                                </p>
                                <div class="teacher-details">
                                    <?php if ($teacher['t_province']): ?>
                                        <span><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($teacher['t_province']); ?> Province</span>
                                    <?php endif; ?>
                                    <?php if ($teacher['t_email']): ?>
                                        <span><i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($teacher['t_email']); ?></span>
                                    <?php endif; ?>
                                    <?php if ($teacher['t_sanketno']): ?>
                                        <span><i class="fa-solid fa-address-card"></i> Sanket No: <?php echo htmlspecialchars($teacher['t_sanketno']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($teacher['t_temporaryaddress'])): ?>
                                        <span><i class="fa-solid fa-house"></i> Temp Address: <?php echo htmlspecialchars($teacher['t_temporaryaddress']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($teacher['t_permanentaddress'])): ?>
                                        <span><i class="fa-solid fa-building"></i> Perm Address: <?php echo htmlspecialchars($teacher['t_permanentaddress']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

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
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>

</html>
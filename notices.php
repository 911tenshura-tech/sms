<?php
require_once 'connection/db.php';
$notices = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM notices ORDER BY date_posted DESC");
        $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle error silently
    }
}
?>
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
         <div class="date-info" id="date">
                <?php
                //date time logic
                    date_default_timezone_set('Asia/Kathmandu');

                    echo date('F j, Y g:i a'); 

                ?>
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

    <main class="public-main">
        <section class="page-header"
            style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
            <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Notices and
                Results</h2>
            <p style="font-size: 1.1rem; color: #666;">Access school resources, notices, and results.</p>
        </section>
    </main>
<?php
// view.php
function viewDocument(){
    if (isset($_GET['file'])) {
    // Sanitize the file_name to prevent Directory Traversal attacks (e.g., passing ../../etc/passwd)
    $file_name = basename($_GET['file']); 
    $file_path = 'assets/uploads/notices/' . $file_name;

    // Check if the file actually exists on the server
    if (file_exists($file_path)) {
        
        // Get the correct MIME type dynamically (e.g., application/pdf, image/jpeg)
        $mimeType = mime_content_type($file_path);
        
        // Set HTTP headers to tell the browser how to handle the file
        header("Content-Type: " . $mimeType);
        
        // "inline" opens it in the browser window. change to "attachment" to force a download.
        header("Content-Disposition: inline; file_name=\"" . $file_name . "\"");
        header("Content-Length: " . filesize($file_path));
        
        // Clear system output buffer to prevent file corruption
        ob_clean();
        flush();
        
        // Read the file and stream it to the user
        readfile($file_path);
        exit;
    } else {
        echo "Error: File not found.";
    }
}
}
?>
    <div class="notices-section" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
        <?php if (empty($notices)): ?>
        <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 8px;">
            <p style="color: #7f8c8d; font-size: 1.1rem;">No notices or results are available at the moment.</p>
        </div>
        <?php else: ?>
        <div style="display: grid; gap: 20px;">
            <?php foreach ($notices as $notice): ?>
            <div
                style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <span
                            style="background-color: <?php echo ($notice['type'] == 'Result' ? '#2ecc71' : '#3498db'); ?>; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; margin-right: 10px;">
                            <?php echo htmlspecialchars($notice['type']); ?>
                        </span>
                        <span style="color: #7f8c8d; font-size: 0.9rem;"><i class="fa-regular fa-clock"></i>
                            <?php echo date('M d, Y', strtotime($notice['date_posted'])); ?></span>
                    </div>
                </div>
                <h3 style="color: #2c3e50; font-size: 1.4rem; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($notice['title']); ?></h3>
                <p style="color: #4a5568; line-height: 1.6; margin-bottom: 15px;">
                    <?php echo nl2br(htmlspecialchars($notice['content'])); ?></p>

                <?php if ($notice['file_path']): ?>
                <a href="assets/uploads/notices/<?php echo htmlspecialchars($notice['file_path']); ?>" target="_blank"
                    style="display: inline-block; background-color: #f1f5f9; color: #3b82f6; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: background 0.2s;">
                    <i class="fa-solid fa-download" style="margin-right: 5px;"></i> Download Attachment
                    <?php viewDocument(); ?>
                    <i class="fa-solid fa-eye" style="margin-right: 3px; margin-left: 10px;"></i> View Attachment
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="fees-section" style="padding: 2rem; max-width: 1200px; margin: 0 auto;">
        <h3>Pay Fees Online</h3>
        <p>Make your fee payments conveniently through our online portal.</p> <br>
        <a href="fees.php" class="btn"
            style="text-decoration: underline; color: #fff; background-color: #3498db; padding: 10px 20px; border-radius: 5px;">Pay
            Now</a>
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
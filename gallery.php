<?php
require_once 'db.php';
$media_items = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
        $media_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $media_items = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Filter Bar */
        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0 35px;
        }
        .filter-btn {
            background: #f0f3f6;
            color: var(--text-dark);
            border: none;
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .filter-btn.active, .filter-btn:hover {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 15px rgba(30, 86, 179, 0.2);
        }

        /* Grid Layout */
        .public-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 0 2rem 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .public-gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 4/3;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            cursor: pointer;
            background: #f0f3f6;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .public-gallery-item img, 
        .public-gallery-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .public-gallery-item:hover img {
            transform: scale(1.08);
        }
        .media-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }
        .public-gallery-item:hover .media-overlay {
            opacity: 1;
        }
        .media-overlay h3 {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .media-type-tag {
            color: rgba(255,255,255,0.75);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .video-play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2.2rem;
            color: white;
            background: rgba(30, 86, 179, 0.85);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            z-index: 1;
        }
        .public-gallery-item:hover .video-play-icon {
            transform: translate(-50%, -50%) scale(1.1);
            background: var(--primary-color);
        }

        /* Modal / Lightbox styling */
        .lightbox-modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 40px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .lightbox-modal.active {
            display: flex;
            opacity: 1;
        }
        .lightbox-content {
            max-width: 90%;
            max-height: 80%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .lightbox-media {
            max-width: 100%;
            max-height: 75vh;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        }
        .lightbox-title {
            color: white;
            margin-top: 15px;
            font-size: 1.25rem;
            font-weight: 500;
            text-align: center;
        }
        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 30px;
            color: rgba(255,255,255,0.7);
            font-size: 2.2rem;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 10000;
        }
        .lightbox-close:hover {
            color: white;
        }
        .no-media-public {
            text-align: center;
            padding: 60px;
            color: var(--text-muted);
            font-size: 1.1rem;
            grid-column: 1 / -1;
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
                <li><a href="notices.php">Notices and Results</a></li>
                <li><a href="gallery.php" class="active">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>

        <main class="public-main">
            <section class="page-header"
                style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Gallery</h2>
                <p style="font-size: 1.1rem; color: #666;">View photos and moments from our school.</p>
            </section>

            <!-- Filter Buttons -->
            <div class="filter-bar">
                <button class="filter-btn active" data-filter="all">All Media</button>
                <button class="filter-btn" data-filter="image">Photos</button>
                <button class="filter-btn" data-filter="video">Videos</button>
            </div>

            <!-- Dynamic Media Grid -->
            <div class="public-gallery-grid">
                <?php if (empty($media_items)): ?>
                    <div class="no-media-public">
                        <i class="fa-solid fa-photo-film" style="font-size: 3.5rem; margin-bottom: 15px; display: block; color: #ccd5df;"></i>
                        No moments captured yet. Check back soon for beautiful updates!
                    </div>
                <?php else: ?>
                    <?php foreach ($media_items as $media): ?>
                        <div class="public-gallery-item" 
                             data-type="<?php echo htmlspecialchars($media['file_type']); ?>"
                             data-src="assets/uploads/gallery/<?php echo htmlspecialchars($media['file_name']); ?>"
                             data-title="<?php echo htmlspecialchars($media['title']); ?>">
                            
                            <?php if ($media['file_type'] === 'image'): ?>
                                <img src="assets/uploads/gallery/<?php echo htmlspecialchars($media['file_name']); ?>" alt="<?php echo htmlspecialchars($media['title']); ?>">
                            <?php else: ?>
                                <video src="assets/uploads/gallery/<?php echo htmlspecialchars($media['file_name']); ?>" muted preload="metadata"></video>
                                <div class="video-play-icon">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            <?php endif; ?>

                            <div class="media-overlay">
                                <h3><?php echo htmlspecialchars($media['title']); ?></h3>
                                <span class="media-type-tag">
                                    <i class="fa-solid <?php echo ($media['file_type'] === 'image') ? 'fa-image' : 'fa-video'; ?>"></i>
                                    <?php echo htmlspecialchars($media['file_type']); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Lightbox Modal -->
            <div class="lightbox-modal" id="lightbox">
                <button class="lightbox-close" id="lightbox-close"><i class="fa-solid fa-xmark"></i></button>
                <div class="lightbox-content">
                    <div id="lightbox-media-container"></div>
                    <div class="lightbox-title" id="lightbox-title"></div>
                </div>
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
                        <div class="gallery-img" style="background-image: url('assets/gallery_1.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/gallery_2.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/gallery_3.jpg');"></div>
                        <div class="gallery-img" style="background-image: url('assets/carousel_2.jpg');"></div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
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
    <script>
        // Gallery Filtering
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.public-gallery-item');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-type') === filterValue) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Lightbox Functionality
        const lightbox = document.getElementById('lightbox');
        const lightboxMediaContainer = document.getElementById('lightbox-media-container');
        const lightboxTitle = document.getElementById('lightbox-title');
        const closeBtn = document.getElementById('lightbox-close');

        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const mediaType = item.getAttribute('data-type');
                const mediaSrc = item.getAttribute('data-src');
                const mediaTitle = item.getAttribute('data-title');

                lightboxMediaContainer.innerHTML = ''; // clear

                if (mediaType === 'image') {
                    const img = document.createElement('img');
                    img.src = mediaSrc;
                    img.className = 'lightbox-media';
                    lightboxMediaContainer.appendChild(img);
                } else if (mediaType === 'video') {
                    const video = document.createElement('video');
                    video.src = mediaSrc;
                    video.className = 'lightbox-media';
                    video.controls = true;
                    video.autoplay = true;
                    lightboxMediaContainer.appendChild(video);
                }

                lightboxTitle.textContent = mediaTitle;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden'; // stop page scroll
            });
        });

        function closeLightbox() {
            lightbox.classList.remove('active');
            lightboxMediaContainer.innerHTML = ''; // Stop video playback
            document.body.style.overflow = 'auto'; // restore page scroll
        }

        closeBtn.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        // Close on Escape keypress
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
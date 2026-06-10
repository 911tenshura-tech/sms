<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connection/db.php';

$success_msg = '';
$error_msg = '';

// Handle Delete Action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = :id");
        $stmt->execute([':id' => $delete_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Delete physical file
            $file_path = '../assets/uploads/gallery/' . $item['file_name'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            // Delete DB record
            $deleteStmt = $pdo->prepare("DELETE FROM gallery WHERE id = :id");
            $deleteStmt->execute([':id' => $delete_id]);
            $success_msg = "Media deleted successfully!";
        }
    } catch (PDOException $e) {
        $error_msg = "Error deleting media: " . $e->getMessage();
    }
}

// Handle Upload Action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    
    if (empty($title)) {
        $error_msg = "Please enter a title for the media.";
    } elseif (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['media_file']['tmp_name'];
        $fileName = $_FILES['media_file']['name'];
        $fileSize = $_FILES['media_file']['size'];
        $fileType = $_FILES['media_file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed Extensions
        $imgExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $vidExtensions = ['mp4', 'webm', 'ogg'];
        $allowedExtensions = array_merge($imgExtensions, $vidExtensions);

        if (in_array($fileExtension, $allowedExtensions)) {
            // Determine type
            $media_type = in_array($fileExtension, $imgExtensions) ? 'image' : 'video';
            
            // Unique file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../assets/uploads/gallery/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                try {
                    $sql = "INSERT INTO gallery (title, file_name, file_type) VALUES (:title, :file_name, :file_type)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,
                        ':file_name' => $newFileName,
                        ':file_type' => $media_type
                    ]);
                    $success_msg = "Media uploaded successfully!";
                } catch (PDOException $e) {
                    $error_msg = "Database error: " . $e->getMessage();
                }
            } else {
                $error_msg = "There was an error moving the uploaded file to the destination folder.";
            }
        } else {
            $error_msg = "Invalid file format. Allowed formats: " . implode(', ', $allowedExtensions);
        }
    } else {
        $error_msg = "Please select a file to upload.";
    }
}

// Fetch all media
try {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    $media_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $media_items = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css?v=1.2">
    <style>
        .split-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .split-layout {
                grid-template-columns: 1fr;
            }
        }
        .form-panel, .list-panel {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 25px;
        }
        .panel-header {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }
        .panel-header h3 {
            color: var(--text-dark);
            font-size: 1.2rem;
            font-weight: 600;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        .form-group input, 
        .form-group select {
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        .form-group input:focus, 
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 86, 179, 0.1);
            outline: none;
        }
        .btn-upload {
            background: var(--primary-color);
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-upload:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(40, 167, 69, 0.2);
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }
        /* Media Grid styling */
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .media-card {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            position: relative;
            transition: transform 0.3s ease;
        }
        .media-card:hover {
            transform: translateY(-5px);
        }
        .media-preview-container {
            height: 150px;
            background: #f0f3f6;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .media-preview-container img, 
        .media-preview-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .media-info {
            padding: 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .media-info h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .media-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            display: inline-block;
            align-self: flex-start;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .badge-image {
            background: rgba(30, 86, 179, 0.1);
            color: var(--primary-color);
        }
        .badge-video {
            background: rgba(252, 163, 17, 0.1);
            color: var(--warning-color);
        }
        .media-delete-btn {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: none;
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin-top: auto;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .media-delete-btn:hover {
            background: var(--danger-color);
            color: white;
        }
        .no-media {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }
    </style>
</head>

<body>

    <div id="admin-view">
        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="admin.php"><img src="../assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2></a>
                
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
             <ul class="sidebar-menu">
                <li><a href="admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="../students/students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="admin_notices.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li class="active"><a href="admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="../index.php"><i class="fa-solid fa-home"></i> <span>Public Site</span></a></li>
            </ul>
        </aside>

        <!-- Main Admin Content -->
        <div class="admin-main-wrapper" id="main-wrapper">

            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                    <h1>Mahendra Maheshdev Secondary School, Likhu-6, Nuwakot, Nepal</h1>
                </div>
                <div class="header-right">
                    <div class="admin-profile">
                        <img src="assets/principal.jpg" alt="Admin" class="avatar">
                        <span class="admin-name">Admin User</span>
                        <button class="logout-btn" onclick="location.href='logout.php'"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">

                <?php if(!empty($success_msg)): ?>
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $success_msg; ?></div>
                <?php endif; ?>

                <?php if(!empty($error_msg)): ?>
                    <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div class="split-layout">
                    
                    <!-- Left: Upload Media Form -->
                    <div class="form-panel">
                        <div class="panel-header">
                            <h3><i class="fa-solid fa-cloud-arrow-up"></i> Upload Media</h3>
                        </div>

                        <form action="admin_gallery.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Media Title *</label>
                                <input type="text" id="title" name="title" required placeholder="E.g. Annual Sports Meet 2026">
                            </div>

                            <div class="form-group">
                                <label for="media_file">Select File *</label>
                                <input type="file" id="media_file" name="media_file" required accept="image/*,video/*" style="padding: 10px; background: var(--bg-light);">
                                <span style="font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;">
                                    Allowed images: jpg, jpeg, png, gif.<br>
                                    Allowed videos: mp4, webm.
                                </span>
                            </div>

                            <button type="submit" class="btn-upload"><i class="fa-solid fa-save"></i> Upload Media</button>
                        </form>
                    </div>

                    <!-- Right: Media Management Grid -->
                    <div class="list-panel">
                        <div class="panel-header">
                            <h3><i class="fa-solid fa-images"></i> Media Library</h3>
                        </div>

                        <div class="media-grid">
                            <?php if (empty($media_items)): ?>
                                <div class="no-media">
                                    <i class="fa-solid fa-photo-film" style="font-size: 3rem; margin-bottom: 10px; display: block; color: #ccd5df;"></i>
                                    No media uploaded yet. Use the upload panel to add your first photo or video!
                                </div>
                            <?php else: ?>
                                <?php foreach ($media_items as $media): ?>
                                    <div class="media-card">
                                        <div class="media-preview-container">
                                            <?php if ($media['file_type'] === 'image'): ?>
                                                <img src="../assets/uploads/gallery/<?php echo htmlspecialchars($media['file_name']); ?>" alt="<?php echo htmlspecialchars($media['title']); ?>">
                                            <?php else: ?>
                                                <video src="../assets/uploads/gallery/<?php echo htmlspecialchars($media['file_name']); ?>" muted preload="metadata"></video>
                                                <!-- Video Overlay Icon -->
                                                <div style="position: absolute; font-size: 1.8rem; color: white; background: rgba(0,0,0,0.4); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; pointer-events: none;">
                                                    <i class="fa-solid fa-play"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-info">
                                            <h4><?php echo htmlspecialchars($media['title']); ?></h4>
                                            
                                            <span class="media-badge <?php echo ($media['file_type'] === 'image') ? 'badge-image' : 'badge-video'; ?>">
                                                <i class="fa-solid <?php echo ($media['file_type'] === 'image') ? 'fa-image' : 'fa-video'; ?>"></i> 
                                                <?php echo htmlspecialchars($media['file_type']); ?>
                                            </span>

                                            <a href="admin_gallery.php?delete_id=<?php echo $media['id']; ?>" class="media-delete-btn" onclick="return confirm('Are you sure you want to permanently delete this media file?')">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="../script.js?v=1.1"></script>
</body>

</html>

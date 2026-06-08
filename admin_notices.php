<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once 'connection/db.php';

// Handle adding a notice
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $type = $_POST['type'] ?? 'Notice';
    
    // File upload logic (optional)
    $file_path = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $upload_dir = 'assets/uploads/notices/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES['file']['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            $file_path = $file_name;
        }
    }

    if (!empty($title) && !empty($content)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO notices (title, content, type, file_path) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $content, $type, $file_path]);
            header("Location: admin_notices.php?msg=added");
            exit;
        } catch (PDOException $e) {
            $error = "Failed to add notice: " . $e->getMessage();
        }
    } else {
        $error = "Title and Content are required.";
    }
}

// Handle deleting a notice
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM notices WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: admin_notices.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete notice: " . $e->getMessage();
    }
}

// Fetch notices
$notices = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM notices ORDER BY date_posted DESC");
        $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Failed to fetch notices.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices - Admin Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css?v=1.1">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .submit-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div id="admin-view">

        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="admin.php"><img src="assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2></a>
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="students/students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-signature"></i> <span>Examination</span></a></li>
                <li><a href="admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li class="active"><a href="admin_notices.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
            </ul>
        </aside>

        <!-- Main Admin Content -->
        <div class="admin-main-wrapper" id="main-wrapper">

            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                    <h1>Manage Notices and Results</h1>
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
                <?php if (isset($error)): ?>
                    <div class="alert" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
                    <div class="alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">Notice added successfully!</div>
                <?php endif; ?>
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                    <div class="alert" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">Notice deleted successfully!</div>
                <?php endif; ?>

                <div class="dashboard-split" style="display: flex; gap: 20px; flex-wrap: wrap;">
                    
                    <!-- Left: Add Notice Form -->
                    <div class="panel" style="flex: 1; min-width: 300px;">
                        <div class="panel-header">
                            <h3>Add New</h3>
                        </div>
                        <form action="admin_notices.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input type="text" id="title" name="title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select id="type" name="type" required>
                                    <option value="Notice">Notice</option>
                                    <option value="Result">Result</option>
                                    <option value="Event">Event</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Content/Description *</label>
                                <textarea id="content" name="content" rows="4" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">Attachment (Optional)</label>
                                <input type="file" id="file" name="file">
                            </div>
                            
                            <button type="submit" class="submit-btn"><i class="fa-solid fa-plus"></i> Add Item</button>
                        </form>
                    </div>

                    <!-- Right: List Notices -->
                    <div class="panel" style="flex: 2; min-width: 400px;">
                        <div class="panel-header">
                            <h3>Existing Notices & Results</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Attachment</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($notices)): ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: #7f8c8d; padding: 20px;">No records found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($notices as $notice): ?>
                                            <tr style="border-bottom: 1px solid #eee;">
                                                <td style="padding: 10px;"><?php echo date('M d, Y', strtotime($notice['date_posted'])); ?></td>
                                                <td style="padding: 10px;"><span class="badge" style="background-color: <?php echo ($notice['type'] == 'Result' ? '#2ecc71' : '#3498db'); ?>; color: white; padding: 4px 8px; border-radius: 12px; font-size: 0.8em;"><?php echo htmlspecialchars($notice['type']); ?></span></td>
                                                <td style="padding: 10px;"><strong><?php echo htmlspecialchars($notice['title']); ?></strong></td>
                                                <td style="padding: 10px;">
                                                    <?php if ($notice['file_path']): ?>
                                                        <a href="assets/uploads/notices/<?php echo htmlspecialchars($notice['file_path']); ?>" target="_blank" style="color: #3498db;"><i class="fa-solid fa-paperclip"></i> View</a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td style="padding: 10px;">
                                                    <a href="admin_notices.php?delete=<?php echo $notice['id']; ?>" onclick="return confirm('Are you sure you want to delete this?');" style="color: #e74c3c; text-decoration: none;"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Custom JS -->
    <script src="script.js?v=1.1"></script>
</body>
</html>

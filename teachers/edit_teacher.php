<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connection/db.php';

$success_msg = '';
$error_msg = '';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: teachers.php");
    exit;
}

// Fetch current details
try {
    $stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$teacher) {
        header("Location: teachers.php");
        exit;
    }
} catch (PDOException $e) {
    $error_msg = "Database error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_firstname = $_POST['t_firstname'] ?? '';
    $t_midname = $_POST['t_midname'] ?? '';
    $t_lastname = $_POST['t_lastname'] ?? '';
    $t_status = $_POST['t_status'] ?? 'Active';
    $t_sanketno = $_POST['t_sanketno'] ?? '';
    $t_address = $_POST['t_address'] ?? '';
    $t_gender = $_POST['t_gender'] ?? '';
    $t_email = $_POST['t_email'] ?? '';
    $t_province = $_POST['t_province'] ?? '';

    // Handle Image Upload
    $t_image = $teacher['t_image']; // Default to old image
    if (isset($_FILES['t_image']) && $_FILES['t_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['t_image']['tmp_name'];
        $fileName = $_FILES['t_image']['name'];
        $fileSize = $_FILES['t_image']['size'];
        $fileType = $_FILES['t_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // unique file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'assets/uploads/teachers/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Delete old image if it exists
                if (!empty($teacher['t_image']) && file_exists('assets/uploads/teachers/' . $teacher['t_image'])) {
                    unlink('assets/uploads/teachers/' . $teacher['t_image']);
                }
                $t_image = $newFileName;
            } else {
                $error_msg = 'There was some error moving the file to upload directory.';
            }
        } else {
            $error_msg = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    }

    if (empty($error_msg) && !empty($t_firstname) && !empty($t_lastname)) {
        try {
            $sql = "UPDATE teachers SET 
                    t_firstname = :firstname, 
                    t_midname = :midname, 
                    t_lastname = :lastname, 
                    t_image = :image, 
                    t_status = :status, 
                    t_sanketno = :sanketno, 
                    t_address = :address, 
                    t_gender = :gender, 
                    t_email = :email, 
                    t_province = :province 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':firstname' => $t_firstname,
                ':midname' => $t_midname,
                ':lastname' => $t_lastname,
                ':image' => $t_image,
                ':status' => $t_status,
                ':sanketno' => $t_sanketno,
                ':address' => $t_address,
                ':gender' => $t_gender,
                ':email' => $t_email,
                ':province' => $t_province,
                ':id' => $id
            ]);
            
            // Redirect with success message
            header("Location: teachers.php?msg=updated");
            exit;
        } catch (PDOException $e) {
            $error_msg = "Database error: " . $e->getMessage();
        }
    } else if (empty($error_msg)) {
        $error_msg = "First Name and Last Name are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css?v=1.2">
    <style>
        .form-panel {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        .form-header h2 {
            color: var(--text-dark);
            font-size: 1.4rem;
        }
        .back-btn {
            background: var(--bg-light);
            color: var(--text-dark);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: #e2e6ea;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }
        .form-group input:focus, 
        .form-group select:focus, 
        .form-group textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 86, 179, 0.1);
            outline: none;
        }
        .submit-btn {
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .submit-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }
        .current-image-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            padding: 10px;
            background: var(--bg-light);
            border-radius: 8px;
            border: 1px dashed var(--border-color);
        }
        .current-image-preview img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div id="admin-view">
        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <img src="assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2>
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="#"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="#"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-signature"></i> <span>Examination</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
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
                
                <div class="form-panel">
                    <div class="form-header">
                        <h2><i class="fa-solid fa-user-pen"></i> Edit Teacher Record</h2>
                        <a href="teachers.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Directory</a>
                    </div>

                    <?php if(!empty($error_msg)): ?>
                        <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <form action="edit_teacher.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            
                            <div class="form-group">
                                <label for="t_firstname">First Name *</label>
                                <input type="text" id="t_firstname" name="t_firstname" required value="<?php echo htmlspecialchars($teacher['t_firstname']); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="t_midname">Middle Name</label>
                                <input type="text" id="t_midname" name="t_midname" value="<?php echo htmlspecialchars($teacher['t_midname'] ?: ''); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="t_lastname">Last Name *</label>
                                <input type="text" id="t_lastname" name="t_lastname" required value="<?php echo htmlspecialchars($teacher['t_lastname']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="t_email">Email Address</label>
                                <input type="email" id="t_email" name="t_email" value="<?php echo htmlspecialchars($teacher['t_email'] ?: ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="t_gender">Gender</label>
                                <select id="t_gender" name="t_gender">
                                    <option value="" disabled>Select Gender</option>
                                    <option value="Male" <?php echo ($teacher['t_gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($teacher['t_gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo ($teacher['t_gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="t_province">Province</label>
                                <select id="t_province" name="t_province">
                                    <option value="" disabled>Select Province</option>
                                    <option value="Koshi" <?php echo ($teacher['t_province'] === 'Koshi') ? 'selected' : ''; ?>>Koshi (Province 1)</option>
                                    <option value="Madhesh" <?php echo ($teacher['t_province'] === 'Madhesh') ? 'selected' : ''; ?>>Madhesh (Province 2)</option>
                                    <option value="Bagmati" <?php echo ($teacher['t_province'] === 'Bagmati') ? 'selected' : ''; ?>>Bagmati (Province 3)</option>
                                    <option value="Gandaki" <?php echo ($teacher['t_province'] === 'Gandaki') ? 'selected' : ''; ?>>Gandaki (Province 4)</option>
                                    <option value="Lumbini" <?php echo ($teacher['t_province'] === 'Lumbini') ? 'selected' : ''; ?>>Lumbini (Province 5)</option>
                                    <option value="Karnali" <?php echo ($teacher['t_province'] === 'Karnali') ? 'selected' : ''; ?>>Karnali (Province 6)</option>
                                    <option value="Sudurpashchim" <?php echo ($teacher['t_province'] === 'Sudurpashchim') ? 'selected' : ''; ?>>Sudurpashchim (Province 7)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="t_sanketno">Sanket No (Symbol No)</label>
                                <input type="text" id="t_sanketno" name="t_sanketno" value="<?php echo htmlspecialchars($teacher['t_sanketno'] ?: ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="t_status">Status</label>
                                <select id="t_status" name="t_status">
                                    <option value="Active" <?php echo ($teacher['t_status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Inactive" <?php echo ($teacher['t_status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="On Leave" <?php echo ($teacher['t_status'] === 'On Leave') ? 'selected' : ''; ?>>On Leave</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="t_address">Full Address</label>
                                <input type="text" id="t_address" name="t_address" value="<?php echo htmlspecialchars($teacher['t_address'] ?: ''); ?>">
                            </div>

                            <div class="form-group full-width">
                                <label>Profile Image</label>
                                <?php if (!empty($teacher['t_image']) && file_exists('assets/uploads/teachers/' . $teacher['t_image'])): ?>
                                    <div class="current-image-preview">
                                        <img src="assets/uploads/teachers/<?php echo htmlspecialchars($teacher['t_image']); ?>" alt="Current Profile Picture">
                                        <div>
                                            <span style="font-weight: 500; font-size: 0.9rem; display: block; color: var(--text-dark);">Current File:</span>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo htmlspecialchars($teacher['t_image']); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <input type="file" id="t_image" name="t_image" accept="image/png, image/jpeg, image/gif" style="padding: 10px; background: var(--bg-light);">
                            </div>

                        </div>
                        
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-save"></i> Save Changes</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="script.js?v=1.1"></script>
</body>
</html>

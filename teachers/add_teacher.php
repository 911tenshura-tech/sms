<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connection/db.php';

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t_firstname = $_POST['t_firstname'] ?? '';
    $t_midname = $_POST['t_midname'] ?? '';
    $t_lastname = $_POST['t_lastname'] ?? '';
    $t_status = $_POST['t_status'] ?? 'Active';
    $t_sanketno = $_POST['t_sanketno'] ?? '';
    $t_temporaryaddress = $_POST['t_temporaryaddress'] ?? '';
    $t_permanentaddress = $_POST['t_permanentaddress'] ?? 'Likhu-6, Nuwakot';
    $t_gender = $_POST['t_gender'] ?? '';
    $t_email = $_POST['t_email'] ?? '';
    $t_province = $_POST['t_province'] ?? 'Bagmati';

    // Handle Image Upload
    $t_image = '';
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
            $uploadFileDir = '../assets/uploads/teachers/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
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
            $sql = "INSERT INTO teachers (t_firstname, t_midname, t_lastname, t_image, t_status, t_sanketno, t_permanentaddress, t_temporaryaddress, t_gender, t_email, t_province) 
                    VALUES (:firstname, :midname, :lastname, :image, :status, :sanketno, :permanentaddress, :temporaryaddress, :gender, :email, :province)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':firstname' => $t_firstname,
                ':midname' => $t_midname,
                ':lastname' => $t_lastname,
                ':image' => $t_image,
                ':status' => $t_status,
                ':sanketno' => $t_sanketno,
                ':permanentaddress' => $t_permanentaddress,
                ':temporaryaddress'=> $t_temporaryaddress,
                ':gender' => $t_gender,
                ':email' => $t_email,
                ':province' => $t_province
            ]);
            $success_msg = "Teacher added successfully!";
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
    <title>Add New Teacher - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css?v=1.2">
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
        .file-upload-wrapper {
            position: relative;
        }
        .file-upload-wrapper input[type="file"] {
            padding: 10px;
            background: var(--bg-light);
        }
    </style>
</head>

<body>

    <div id="admin-view">
        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="../admin.php"><img src="../assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2></a>
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
               <ul class="sidebar-menu">
                <li><a href="../admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="../students/students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li class="active"><a href="teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="../admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="../about.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="../admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
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
                        <img src="../assets/principal.jpg" alt="Admin" class="avatar">
                        <span class="admin-name">Admin User</span>
                        <button class="logout-btn" onclick="location.href='../logout.php'"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                
                <div class="form-panel">
                    <div class="form-header">
                        <h2><i class="fa-solid fa-user-plus"></i> Add New Teacher</h2>
                        <a href="teachers.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Directory</a>
                    </div>

                    <?php if(!empty($success_msg)): ?>
                        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $success_msg; ?></div>
                    <?php endif; ?>

                    <?php if(!empty($error_msg)): ?>
                        <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <form action="add_teacher.php" method="POST" enctype="multipart/form-data">
                        <div class="form-grid">
                            
                            <div class="form-group">
                                <label for="t_firstname">First Name </label>
                                <input type="text" id="t_firstname" name="t_firstname" required placeholder="Enter first name">
                            </div>
                            
                            <div class="form-group">
                                <label for="t_midname">Middle Name *</label>
                                <input type="text" id="t_midname" name="t_midname" placeholder="Enter middle name (optional)">
                            </div>
                            
                            <div class="form-group">
                                <label for="t_lastname">Last Name </label>
                                <input type="text" id="t_lastname" name="t_lastname" required placeholder="Enter last name">
                            </div>

                            <div class="form-group">
                                <label for="t_email">Email Address</label>
                                <input type="email" id="t_email" name="t_email" placeholder="example@school.com">
                            </div>

                            <div class="form-group">
                                <label for="t_gender">Gender</label>
                                <select id="t_gender" name="t_gender">
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="t_province">Province</label>
                                <select id="t_province" name="t_province">
                                    <option value="" disabled selected>Select Province</option>
                                    <option value="Koshi">Koshi (Province 1)</option>
                                    <option value="Madhesh">Madhesh (Province 2)</option>
                                    <option value="Bagmati">Bagmati (Province 3)</option>
                                    <option value="Gandaki">Gandaki (Province 4)</option>
                                    <option value="Lumbini">Lumbini (Province 5)</option>
                                    <option value="Karnali">Karnali (Province 6)</option>
                                    <option value="Sudurpashchim">Sudurpashchim (Province 7)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="t_sanketno">Sanket No (Symbol No)</label>
                                <input type="text" id="t_sanketno" name="t_sanketno" placeholder="Teacher ID / Symbol No">
                            </div>

                            <div class="form-group">
                                <label for="t_status">Status</label>
                                <select id="t_status" name="t_status">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="On Leave">On Leave</option>
                                </select>
                            </div>
                            
                            <div class="form-group full-width">
                                <label for="t_temporaryaddress">Temporary Address</label>
                                <input type="text" id="t_temporaryaddress" name="t_temporaryaddress" placeholder="Enter complete Temporary address">
                            </div>

                            <div class="form-group full-width">
                                <label for="t_permanentaddress">Permanent Address</label>
                                <input type="text" id="t_permanentaddress" name="t_permanentaddress" placeholder="Enter complete permanent residential address">
                            </div>

                            <div class="form-group full-width">
                                <label for="t_image">Profile Image</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" id="t_image" name="t_image" accept="image/png, image/jpeg, image/gif">
                                </div>
                            </div>

                        </div>
                        
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-save"></i> Save Teacher Record</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Custom JS -->
    <script src="script.js?v=1.1"></script>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connection/db.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM teachers ORDER BY created_at DESC");
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $teachers = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers Management - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css?v=1.2">
    <style>
        .panel {
            background: var(--bg-white);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 25px;
            margin-bottom: 30px;
        }
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        .panel-header h3 {
            color: var(--text-dark);
            font-size: 1.3rem;
            font-weight: 600;
        }
        .add-btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .add-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        .teacher-avatar-sm {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
            background-color: #f0f3f6;
        }
        .teacher-avatar-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            color: #495057;
            font-size: 1.2rem;
            border: 2px solid var(--border-color);
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }
        .badge-inactive {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        .badge-on-leave {
            background-color: rgba(252, 163, 17, 0.1);
            color: var(--warning-color);
        }
        .action-cell {
            display: flex;
            gap: 8px;
        }
        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
        }
        .action-btn-edit {
            background-color: rgba(30, 86, 179, 0.1);
            color: var(--primary-color);
        }
        .action-btn-edit:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .action-btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        .action-btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(40, 167, 69, 0.2);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
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
                <li class="active"><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
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

                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> Teacher record deleted successfully!</div>
                <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
                    <div class="alert-success"><i class="fa-solid fa-circle-check"></i> Teacher record updated successfully!</div>
                <?php endif; ?>

                <div class="panel">
                    <div class="panel-header">
                        <h3><i class="fa-solid fa-chalkboard-user"></i> Teachers Directory</h3>
                        <a href="add_teacher.php" class="add-btn"><i class="fa-solid fa-user-plus"></i> Add New Teacher</a>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Province</th>
                                    <th>Sanket No.</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($teachers)): ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                            <i class="fa-solid fa-user-slash" style="font-size: 2.5rem; margin-bottom: 10px; display: block;"></i>
                                            No teachers found. Click "Add New Teacher" to get started.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($teacher['t_image']) && file_exists('../assets/uploads/teachers/' . $teacher['t_image'])): ?>
                                                    <img src="../assets/uploads/teachers/<?php echo htmlspecialchars($teacher['t_image']); ?>" alt="Avatar" class="teacher-avatar-sm">
                                                <?php else: ?>
                                                    <div class="teacher-avatar-placeholder">
                                                        <i class="fa-solid fa-chalkboard-user"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($teacher['t_firstname'] . ($teacher['t_midname'] ? ' ' . $teacher['t_midname'] : '') . ' ' . $teacher['t_lastname']); ?></strong>
                                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px;">
                                                    <i class="fa-solid fa-venus-mars"></i> <?php echo htmlspecialchars($teacher['t_gender'] ?: 'Unspecified'); ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($teacher['t_email'] ?: '-'); ?></td>
                                            <td><?php echo htmlspecialchars($teacher['t_province'] ? $teacher['t_province'] . ' Province' : '-'); ?></td>
                                            <td><code><?php echo htmlspecialchars($teacher['t_sanketno'] ?: '-'); ?></code></td>
                                            <td>
                                                <?php 
                                                $status = $teacher['t_status'] ?: 'Active';
                                                $badgeClass = 'badge-active';
                                                if ($status === 'Inactive') $badgeClass = 'badge-inactive';
                                                if ($status === 'On Leave') $badgeClass = 'badge-on-leave';
                                                ?>
                                                <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                            </td>
                                            <td>
                                                <div class="action-cell">
                                                    <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>" class="action-btn action-btn-edit" title="Edit Teacher">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" onclick="confirmDelete(<?php echo $teacher['id']; ?>)" class="action-btn action-btn-delete" title="Delete Teacher">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
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

    <!-- Custom JS -->
    <script src="script.js?v=1.1"></script>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to permanently delete this teacher record? This will also remove their profile picture and cannot be undone.")) {
                window.location.href = "delete_teacher.php?id=" + id;
            }
        }
    </script>
</body>

</html>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connection/db.php';

// Fetch fee records
$fee_records = [];

if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM fees ORDER BY pay_date DESC");
        $fee_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Fallback in case of errors
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fees - Admin Dashboard</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css?v=1.1">
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
                <li class="active"><a href="admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="admin_notices.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="../index.php"><i class="fa-solid fa-home"></i> <span>Public Site</span></a></li>
            </ul>
        </aside>

        <!-- Main Admin Content -->
        <div class="admin-main-wrapper" id="main-wrapper">

            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
                    <h1>Fee Management</h1>
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
                <div class="panel">
                    <div class="panel-header">
                        <h3>Fee Payment Records</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Payer Name</th>
                                    <th>Fee Type</th>
                                    <th>Amount (NPR)</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($fee_records)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 20px;">No fee records found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $count = 1; foreach ($fee_records as $record): ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><strong><?php echo htmlspecialchars($record['student_name']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($record['class']); ?></td>
                                            <td><?php echo htmlspecialchars($record['payers_name']); ?></td>
                                            <td><?php echo htmlspecialchars($record['fee_type']); ?></td>
                                            <td><?php echo htmlspecialchars(number_format($record['amount'], 2)); ?></td>
                                            <td>
                                                <?php 
                                                $status = $record['status'] ?: 'Pending';
                                                $badgeClass = 'badge active';
                                                if ($status === 'Pending') $badgeClass = 'badge warning';
                                                if ($status === 'Failed') $badgeClass = 'badge inactive';
                                                ?>
                                                <span class="<?php echo $badgeClass; ?>" style="padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; color: #fff; background-color: <?php echo ($status === 'Pending' ? '#f39c12' : ($status === 'Failed' ? '#e74c3c' : '#2ecc71')); ?>;"><?php echo htmlspecialchars($status); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars(date('M d, Y', strtotime($record['pay_date']))); ?></td>
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
</body>
</html>

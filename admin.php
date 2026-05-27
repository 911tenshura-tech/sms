<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once 'connection/db.php';

// Fetch Statistics
$total_teachers = 0;
$active_teachers = 0;
$latest_teachers = [];

if (isset($pdo)) {
    try {
        // Total Teachers
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM teachers");
        $total_teachers = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

        // Active Teachers
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM teachers WHERE t_status = 'Active'");
        $active_teachers = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

        // Fetch 5 Latest Teachers
        $stmt = $pdo->query("SELECT * FROM teachers ORDER BY created_at DESC LIMIT 5");
        $latest_teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Admin Dashboard - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css?v=1.1">
    <style>
        .nav-link {
    position: relative;
    display: inline-block;
    padding: 10px;
    color: #2c3e50;
    text-decoration: none;
    font-weight: 600;
}
.badge {
    position: absolute;
    top: 4px;
    right: -2px;
    width: 10px;
    height: 10px;
    background-color: #e74c3c; /* Red */
    border-radius: 50%;
    border: 2px solid #ffffff;
}
.hidden { display: none; }
    </style>
</head>

<body>

    <!-- ========================================== -->
    <!-- ADMIN DASHBOARD VIEW                       -->
    <!-- ========================================== -->
    <div id="admin-view">

        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="admin.php"><img src="assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2></a>
                
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="students/students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-signature"></i> <span>Examination</span></a></li>
                <li><a href="students/std_admission_form_view.php"><i class="fa fa-user-plus"></i> <span>Admissions</span><span id="notification-badge" class="badge hidden"></span></a></li>
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

                <!-- Analytics Cards -->
                <div class="analytics-grid">
                    <div class="metric-card primary-gradient">
                        <div class="metric-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="metric-info">
                            <p>Total Students</p>
                            <h3>452 <span class="trend up">(+5%)</span></h3>
                        </div>
                    </div>
                    <div class="metric-card secondary-gradient">
                        <div class="metric-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div class="metric-info">
                            <p>Total Teachers</p>
                            <h3><?php echo $total_teachers; ?> <span class="trend"><?php echo $active_teachers; ?> active</span></h3>
                        </div>
                    </div>
                    <!-- <div class="metric-card success-gradient">
                        <div class="metric-icon"><i class="fa-solid fa-user-plus"></i></div>
                        <div class="metric-info">
                            <p>New Admissions</p>
                            <h3>12 <span class="trend">this month</span></h3>
                        </div>
                    </div> -->
                    <!-- <div class="metric-card warning-gradient">
                        <div class="metric-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                        <div class="metric-info">
                            <p>Attendance Today</p>
                            <h3>94.2% <span class="trend up">good</span></h3>
                        </div>
                    </div> -->
                </div>

                <!-- Main Split Layout -->
                <div class="dashboard-split">

                    <!-- Left Column -->
                    <div class="split-left">

                        <!-- Active Teachers Records -->
                        <div class="panel">
                            <div class="panel-header">
                                <h3>Active Teachers Records</h3>
                                <button class="btn-sm" onclick="location.href='teachers/add_teacher.php'"><i class="fa-solid fa-plus"></i> Add New</button>
                            </div>
                            <div class="table-responsive">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sanket No</th>
                                            <th>Teacher Name</th>
                                            <th>Province</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($latest_teachers)): ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">No teacher records found.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $count = 1; foreach ($latest_teachers as $teacher): ?>
                                                <tr>
                                                    <td><?php echo $count++; ?></td>
                                                    <td><code><?php echo htmlspecialchars($teacher['t_sanketno'] ?: '-'); ?></code></td>
                                                    <td><strong><?php echo htmlspecialchars($teacher['t_firstname'] . ($teacher['t_midname'] ? ' ' . $teacher['t_midname'] : '') . ' ' . $teacher['t_lastname']); ?></strong></td>
                                                    <td><?php echo htmlspecialchars($teacher['t_province'] ?: '-'); ?></td>
                                                    <td>
                                                        <?php 
                                                        $status = $teacher['t_status'] ?: 'Active';
                                                        $badgeClass = 'badge active';
                                                        if ($status === 'Inactive') $badgeClass = 'badge inactive';
                                                        if ($status === 'On Leave') $badgeClass = 'badge on-leave';
                                                        ?>
                                                        <span class="<?php echo $badgeClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                                    </td>
                                                    <td>
                                                        <button class="action-btn view" onclick="location.href='teachers/teachers.php'"><i class="fa-solid fa-eye"></i></button>
                                                        <button class="action-btn edit" onclick="location.href='teachers/edit_teacher.php?id=<?php echo $teacher['id']; ?>'"><i class="fa-solid fa-pen"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Recent Notifications -->
                        <div class="panel">
                            <div class="panel-header">
                                <h3>Recent Notifications</h3>
                                <a href="#" class="view-all">View All</a>
                            </div>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-icon warning"><i class="fa-solid fa-money-bill"></i></div>
                                    <div class="timeline-content">
                                        <h4>Fee Deadline Reminder</h4>
                                        <p>Automated alerts sent to 45 parents for Term 2 fees.</p>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-icon success"><i class="fa-solid fa-calendar-check"></i></div>
                                    <div class="timeline-content">
                                        <h4>Public Holiday Declared</h4>
                                        <p>School will remain closed tomorrow for local festival.</p>
                                        <span class="time">5 hours ago</span>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-icon primary"><i class="fa-solid fa-bullhorn"></i></div>
                                    <div class="timeline-content">
                                        <h4>Morning Assembly Alert</h4>
                                        <p>Special assembly scheduled for Friday regarding sports week.</p>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="split-right">

                        <!-- Attendance Overview Chart -->
                        <div class="panel chart-panel">
                            <div class="panel-header">
                                <h3>Today's Attendance</h3>
                            </div>
                            <div class="chart-container" style="position: relative; height:250px; width:100%">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>

                        <!-- Examination Results Chart -->
                        <div class="panel chart-panel">
                            <div class="panel-header">
                                <h3>Examination Results (Average %)</h3>
                            </div>
                            <div class="chart-container" style="position: relative; height:300px; width:100%">
                                <canvas id="resultsChart"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <script src="script.js?v=1.1"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const badge = document.getElementById("notification-badge");

            function checkNewAdmissions() {
                // Points to the micro API checking database flags
                fetch('students/check_notification.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.unread_count > 0) {
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    })
                    .catch(error => console.error('Notification error:', error));
            }

            checkNewAdmissions();
            setInterval(checkNewAdmissions, 10000); // Check every 10 seconds
        });
    </script>
</body>

</html>

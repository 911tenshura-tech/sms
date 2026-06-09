<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div id="admin-view">

        <!-- Sidebar -->
        <aside class="sidebar" id="admin-sidebar">
            <div class="sidebar-header">
                <a href="../admin.php"><img src="../assets/logo.png" alt="Logo" class="logo-img small">
                    <h2>M.M.S.S</h2>
                </a>

                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li><a href="../admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a>
                </li>
                <li class="active"><a href="students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i>
                        <span>Teachers</span></a></li>
                <li><a href="../admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="../admin_notices.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and
                            Results</span></a></li>
                <li><a href="../admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="../index.php"><i class="fa-solid fa-home"></i> <span>Public Site</span></a></li>
            </ul>
        </aside>
        <div class="admin-main-wrapper">


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
                        <button class="logout-btn" onclick="location.href='../logout.php'"><i
                                class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            </header>

            <div class="dashboard-content" style="padding: 20px;">
                <h1 style="margin-bottom: 20px; color: #2c3e50;">Student </h1>
                <div class="analytics-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">

                    <a href="std_admission_form_view.php" style="text-decoration: none; color: inherit;">
                        <div class="metric-card"
                            style="background: linear-gradient(135deg, #3498db, #2980b9); color: white; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s;">
                            <div class="metric-icon"
                                style="font-size: 2rem; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 50%;">
                                <i class="fa-solid fa-file-signature"></i></div>
                            <div class="metric-info">
                                <h3 style="margin: 0; font-size: 1.2rem;">Applicant Dashboard</h3>
                                <p style="margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Review and process new
                                    admission forms</p>
                            </div>
                        </div>
                    </a>

                    <a href="add_new_student.php" style="text-decoration: none; color: inherit;">
                        <div class="metric-card"
                            style="background: linear-gradient(135deg, #2ecc71, #27ae60); color: white; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s;">
                            <div class="metric-icon"
                                style="font-size: 2rem; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 50%;">
                                <i class="fa-solid fa-user-plus"></i></div>
                            <div class="metric-info">
                                <h3 style="margin: 0; font-size: 1.2rem;">Add New Student</h3>
                                <p style="margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Manually register a new
                                    student</p>
                            </div>
                        </div>
                    </a>

                    <a href="manage_students.php" style="text-decoration: none; color: inherit;">
                        <div class="metric-card"
                            style="background: linear-gradient(135deg, #f39c12, #d35400); color: white; padding: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.2s;">
                            <div class="metric-icon"
                                style="font-size: 2rem; background: rgba(255,255,255,0.2); padding: 15px; border-radius: 50%;">
                                <i class="fa-solid fa-user-pen"></i></div>
                            <div class="metric-info">
                                <h3 style="margin: 0; font-size: 1.2rem;">Manage Students</h3>
                                <p style="margin: 5px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Update or delete student
                                    records</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
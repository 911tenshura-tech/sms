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
                <a href="admin.php"><img src="../assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2></a>
                
                <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="../admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-signature"></i> <span>Examination</span></a></li>
                <li><a href="#"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="../admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
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
                        <button class="logout-btn" onclick="location.href='../logout.php'"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            </header>

             <h1>Students</h1>
            <a href="student_admissions.php">Add New Student</a>
        </div>
    </div>
</body>
</html>
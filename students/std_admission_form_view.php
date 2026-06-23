<?php
$connection = new mysqli("localhost", "root", "", "sms_db");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Mark all unread admissions as read when admin views the dashboard
$connection->query("UPDATE student_admissions SET status = 'read' WHERE status = 'unread'");

//fetch entries from the database of admission form
$sql = "SELECT * FROM student_admissions ORDER BY id DESC";
$result = $connection->query($sql);
$admissions = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student admission form review</title>
            <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; padding: 20px; }
        .panel-container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .table-responsive { overflow-x: auto; margin-top: 10px; }
        h2 { color: #2c3e50; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-size: 0.9rem; }
        th { background-color: #2c3e50; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .view-btn { padding: 5px 10px; background: #3498db; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.85rem; border: none; cursor: pointer; }
        .view-btn.action { background: #e67e22; }
        
        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 5% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 700px; border-radius: 8px; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .detail-item strong { color: #2c3e50; display: block; margin-bottom: 5px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .detail-item span { color: #555; font-size: 0.95rem; }
        .modal-header { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    
<div id="admin-view">

    <!-- Sidebar -->
    <aside class="sidebar" id="admin-sidebar">
        <div class="sidebar-header">
            <a href="../admin/admin.php"><img src="../assets/logo.png" alt="Logo" class="logo-img small">
                <h2>M.M.S.S</h2>
            </a>
            <button class="toggle-sidebar" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="../admin/admin.php"><i class="fa-solid fa-chart-line"></i> <span>Dashboard</span></a></li>
            <li class="active"><a href="students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
            <li><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
            <li><a href="../admin/admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
            <li><a href="../admin_notices.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
            <li><a href="../admin/admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
            <li><a href="../index.php"><i class="fa-solid fa-home"></i> <span>Public Site</span></a></li>
        </ul>
    </aside>

    <div class="admin-main-wrapper" style="padding: 20px;">
        <a href="students.php" style="text-decoration: none; color: #3498db; margin-bottom: 20px; display: inline-block;">&larr; Back to Students Dashboard</a>
        <div class="panel-container" style="max-width: 100%; margin: 0;">
            <h2>Mahendra Maheshdev Secondary School - Applicant Dashboard</h2>
            <div class="table-responsive">
            <table>
                <thead>
            <tr>
                <th>ID</th>
                <th>Admission Date</th>
                <th>Student Name</th>
                <th>Class Applied</th>
                <th>Parent Contact</th>
                <th>Documents</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): 
                $student_name = htmlspecialchars(trim($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']));
                $parent_contact = htmlspecialchars($row['parent_name'] . ' (' . $row['parent_phone'] . ')');
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['admission_date']); ?></td>
                <td><?php echo $student_name; ?></td>
                <td><?php echo strtoupper(htmlspecialchars($row['class_applied'])); ?></td>
                <td><?php echo $parent_contact; ?></td>
                <td>
                    <?php if(!empty($row['birth_certificate'])): ?>
                        <a class="view-btn" href="../<?php echo $row['birth_certificate']; ?>" target="_blank">Birth Cert</a>
                    <?php endif; ?>
                    <?php if(!empty($row['marksheet'])): ?>
                        <a class="view-btn" style="background:#2ecc71;" href="../<?php echo $row['marksheet']; ?>" target="_blank">Marksheet</a>
                    <?php endif; ?>
                </td>
                <td>
                    <button class="view-btn action" onclick='showDetails(<?php echo json_encode($row); ?>)'><i class="fa-solid fa-eye"></i> View Details</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- The Modal -->
<div id="detailsModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
        <span class="close">&times;</span>
        <h3 id="modalStudentName" style="margin: 0; color: #2c3e50;">Student Details</h3>
    </div>
    <div class="detail-grid" id="modalGrid">
        <!-- Details populated by JS -->
    </div>
  </div>
</div>

<script>
    var modal = document.getElementById("detailsModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function showDetails(data) {
        var fullName = (data.first_name + ' ' + (data.middle_name ? data.middle_name + ' ' : '') + data.last_name).trim();
        document.getElementById('modalStudentName').innerText = fullName + ' - Admission Details';
        
        var grid = document.getElementById('modalGrid');
        grid.innerHTML = `
            <div class="detail-item"><strong>Date of Birth</strong><span>${data.dob || '-'}</span></div>
            <div class="detail-item"><strong>Gender</strong><span>${data.gender || '-'}</span></div>
            <div class="detail-item"><strong>Academic Year</strong><span>${data.academic_year || '-'}</span></div>
            <div class="detail-item"><strong>Class Applied</strong><span>${data.class_applied ? data.class_applied.toUpperCase() : '-'}</span></div>
            <div class="detail-item"><strong>Student Phone</strong><span>${data.student_phone || '-'}</span></div>
            <div class="detail-item"><strong>Student Email</strong><span>${data.student_email || '-'}</span></div>
            <div class="detail-item" style="grid-column: span 2;"><strong>Address</strong><span>${data.address || '-'}</span></div>
            
            <div class="detail-item"><strong>Parent Name</strong><span>${data.parent_name || '-'}</span></div>
            <div class="detail-item"><strong>Relation</strong><span>${data.parent_relation || '-'}</span></div>
            <div class="detail-item"><strong>Parent Phone</strong><span>${data.parent_phone || '-'}</span></div>
            <div class="detail-item"><strong>Parent Email</strong><span>${data.parent_email || '-'}</span></div>
            
            <div class="detail-item"><strong>Previous School</strong><span>${data.prev_school || '-'}</span></div>
            <div class="detail-item"><strong>Previous Grade / GPA</strong><span>${data.prev_grade || '-'} / ${data.prev_gpa || '-'}</span></div>
        `;
        
        modal.style.display = "block";
    }
</script>

    </div>
</div>
</div>
<script src="../script.js"></script>
</body>
</html>
<?php
$connection->close();
?>
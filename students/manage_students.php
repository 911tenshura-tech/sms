<?php
$connection = new mysqli("localhost", "root", "", "sms_db");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

//fetch entries from the database
$sql = "SELECT * FROM student_admissions ORDER BY id DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
        .view-btn { padding: 5px 10px; background: #3498db; color: #fff; text-decoration: none; border-radius: 4px; font-size: 0.85rem; border: none; cursor: pointer; display: inline-block;}
        .view-btn.action { background: #f39c12; }
        .view-btn.danger { background: #e74c3c; }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    
<div class="panel-container">
    <h2>Mahendra Maheshdev Secondary School - Manage Students</h2>
    <a href="students.php" style="text-decoration: none; color: #3498db; margin-bottom: 20px; display: inline-block;">&larr; Back to Students Dashboard</a>
    
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            Student record deleted successfully!
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            Student record updated successfully!
        </div>
    <?php endif; ?>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Admission Date</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Parent Contact</th>
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
                    <a class="view-btn action" href="edit_student.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen"></i> Edit</a>
                    <a class="view-btn danger" href="delete_student.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');"><i class="fa-solid fa-trash"></i> Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>
<?php
$connection->close();
?>

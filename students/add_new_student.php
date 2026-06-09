<?php
// -------------------------------------------------------
// Handle form submission FIRST, before any HTML output
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // DB connection
    $servername = "localhost";
    $db_user    = "root";
    $db_pass    = "";
    $db_name    = "sms_db";

    $conn = new mysqli($servername, $db_user, $db_pass, $db_name);

    // Check connection BEFORE doing anything with it
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ---- File upload handling ----
    $upload_dir = __DIR__ . "/assets/uploads/students/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $birth_certificate_path = "";
    $marksheet_path         = "";

    // Upload birth certificate
    if (isset($_FILES['birth_certificate']) && $_FILES['birth_certificate']['error'] === UPLOAD_ERR_OK) {
        $ext                    = pathinfo($_FILES['birth_certificate']['name'], PATHINFO_EXTENSION);
        $safe_name              = uniqid('bc_') . '.' . $ext;
        $birth_certificate_path = "assets/uploads/students/" . $safe_name;
        move_uploaded_file($_FILES['birth_certificate']['tmp_name'], $upload_dir . $safe_name);
    }

    // Upload marksheet
    if (isset($_FILES['marksheet']) && $_FILES['marksheet']['error'] === UPLOAD_ERR_OK) {
        $ext            = pathinfo($_FILES['marksheet']['name'], PATHINFO_EXTENSION);
        $safe_name      = uniqid('ms_') . '.' . $ext;
        $marksheet_path = "assets/uploads/students/" . $safe_name;
        move_uploaded_file($_FILES['marksheet']['tmp_name'], $upload_dir . $safe_name);
    }

    // ---- Collect & sanitize form data ----
    $admission_date  = $_POST['admission_date']  ?? '';
    $academic_year   = $_POST['academic_year']   ?? '';
    $class_applied   = $_POST['class_applied']   ?? '';
    $first_name      = $_POST['first_name']      ?? '';
    $middle_name     = $_POST['middle_name']     ?? '';
    $last_name       = $_POST['last_name']       ?? '';
    $dob             = $_POST['dob']             ?? '';
    $gender          = $_POST['gender']          ?? '';
    $student_email   = $_POST['student_email']   ?? '';
    $student_phone   = $_POST['student_phone']   ?? '';
    $address         = $_POST['address']         ?? '';
    $parent_name     = $_POST['parent_name']     ?? '';
    $parent_relation = $_POST['parent_relation'] ?? '';
    $parent_phone    = $_POST['parent_phone']    ?? '';
    $parent_email    = $_POST['parent_email']    ?? '';
    $prev_school     = $_POST['prev_school']     ?? '';
    $prev_grade      = $_POST['prev_grade']      ?? '';
    $prev_gpa        = $_POST['prev_gpa']        ?? '';

    // ---- Insert into database ----
    $sql = "INSERT INTO student_admissions
                (admission_date, academic_year, class_applied, first_name, middle_name, last_name,
                 dob, gender, student_email, student_phone, address, parent_name, parent_relation,
                 parent_phone, parent_email, prev_school, prev_grade, prev_gpa,
                 birth_certificate, marksheet)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("MySQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssssss",
        $admission_date, $academic_year, $class_applied, $first_name, $middle_name, $last_name,
        $dob, $gender, $student_email, $student_phone, $address, $parent_name,
        $parent_relation, $parent_phone, $parent_email, $prev_school, $prev_grade, $prev_gpa,
        $birth_certificate_path, $marksheet_path
    );

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirect with success — only called once
        header("Location: student_admissions.php?msg=success");
        exit;
    } else {
        $error_msg = "Submission Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Admission Form - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-header h1 {
            margin-bottom: 0.5rem;
            color: var(--primary-color, #2c3e50);
        }
        .form-header p {
            color: #666;
        }
        .form-section {
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--primary-color, #2c3e50);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .radio-checkbox-group {
            display: flex;
            gap: 1rem;
        }
        .radio-checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .declaration-box {
            background-color: #f9f9f9;
            padding: 1rem;
            border-left: 4px solid var(--primary-color, #2c3e50);
            margin-bottom: 1.5rem;
        }
        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .btn-container button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-container button[type="reset"] {
            background-color: #ccc;
            color: #333;
        }
        .btn-container button[type="submit"] {
            background-color: var(--primary-color, #2c3e50);
            color: #fff;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
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
                <li class="active"><a href="students.php"><i class="fa-solid fa-users"></i> <span>Students</span></a></li>
                <li><a href="../teachers/teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a></li>
                <li><a href="../admin_fees.php"><i class="fa-solid fa-file-invoice-dollar"></i> <span>Fees</span></a></li>
                <li><a href="../about.php"><i class="fa-solid fa-calendar-days"></i> <span>Notices and Results</span></a></li>
                <li><a href="../admin_gallery.php"><i class="fa-solid fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="../index.php"><i class="fa-solid fa-home"></i> <span>Public Site</span></a></li>
            </ul>
        </aside>
  

    <div class="form-container">
        <div class="form-header">
            <div class="logo-container">
                <img src="../assets/logo.png" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <h1 style="font-size: 1.5rem;">Mahendra Maheshdev Secondary School</h1>
                    <p style="font-size: 1.2rem;">Likhu-6, Nuwakot, Nepal</p>
                </div>
            </div>
            <h1>Student Admission Form</h1>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i>
                Your admission form has been submitted successfully! We will contact you shortly.
            </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <!-- enctype is required for file uploads -->
        <form action="student_admissions.php" method="POST" enctype="multipart/form-data">

            <div class="form-section">
                <div class="section-title">1. Academic Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="admission_date">Admission Date *</label>
                        <input type="date" id="admission_date" name="admission_date" required>
                    </div>
                    <div class="form-group">
                        <label for="academic_year">Academic Year *</label>
                        <select id="academic_year" name="academic_year" required>
                            <option value="">-- Select Year --</option>
                            <option value="2026-2027">2026-2027</option>
                            <option value="2027-2028">2027-2028</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_applied">Class Applied *</label>
                        <select id="class_applied" name="class_applied" required>
                            <option value="">-- Select Class --</option>
                            <option value="nursery">Nursery</option>
                            <option value="lkg">LKG</option>
                            <option value="ukg">UKG</option>
                            <option value="1">Class 1</option>
                            <option value="2">Class 2</option>
                            <option value="3">Class 3</option>
                            <option value="4">Class 4</option>
                            <option value="5">Class 5</option>
                            <option value="6">Class 6</option>
                            <option value="7">Class 7</option>
                            <option value="8">Class 8</option>
                            <option value="9">Class 9</option>
                            <option value="10">Class 10</option>
                            <option value="11">Class 11</option>
                            <option value="12">Class 12</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">2. Student Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth *</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <div class="form-group">
                        <label>Gender *</label>
                        <div class="radio-checkbox-group">
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="male" required> Male</label>
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="female"> Female</label>
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="other"> Other</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">3. Contact &amp; Address Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_email">Student Email</label>
                        <input type="email" id="student_email" name="student_email" placeholder="student@example.com">
                    </div>
                    <div class="form-group">
                        <label for="student_phone">Student Mobile</label>
                        <input type="tel" id="student_phone" name="student_phone" placeholder="+977 9XXXXXXXXX">
                    </div>
                    <div class="form-group full-width">
                        <label for="address">Current Residential Address *</label>
                        <textarea id="address" name="address" rows="2" required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">4. Parent / Guardian Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="parent_name">Parent/Guardian Full Name *</label>
                        <input type="text" id="parent_name" name="parent_name" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_relation">Relationship to Student *</label>
                        <input type="text" id="parent_relation" name="parent_relation" placeholder="e.g., Father, Mother" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_phone">Mobile Number *</label>
                        <input type="tel" id="parent_phone" name="parent_phone" placeholder="+977 9XXXXXXXXX" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_email">Parent Email Address</label>
                        <input type="email" id="parent_email" name="parent_email">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">5. Previous Academic History</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="prev_school">Last School Attended</label>
                        <input type="text" id="prev_school" name="prev_school">
                    </div>
                    <div class="form-group">
                        <label for="prev_grade">Highest Grade Completed</label>
                        <input type="text" id="prev_grade" name="prev_grade">
                    </div>
                    <div class="form-group">
                        <label for="prev_gpa">Grade Point Average (GPA)</label>
                        <input type="text" id="prev_gpa" name="prev_gpa">
                    </div>
                    <div class="form-group">
                        <label for="birth_certificate">Birth Certificate Image *</label>
                        <input type="file" id="birth_certificate" name="birth_certificate" accept="image/*,.pdf" required>
                    </div>
                    <div class="form-group">
                        <label for="marksheet">Marksheet of Previous Academic Year *</label>
                        <input type="file" id="marksheet" name="marksheet" accept="image/*,.pdf" required>
                    </div>
                </div>
            </div>

            <div class="declaration-box">
                I hereby declare that the information provided above is true and accurate to the best of my knowledge.
                I understand that any false statements may result in the cancellation of admission.
            </div>

            <div class="btn-container">
                <button type="reset">Reset Form</button>
                <button type="submit">Submit Application</button>
            </div>

        </form>
    </div>
   </div>
    

    <script src="script.js"></script>
</body>
</html>
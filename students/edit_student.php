<?php
// DB connection
$servername = "localhost";
$db_user    = "root";
$db_pass    = "";
$db_name    = "sms_db";

$conn = new mysqli($servername, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

if ($id === 0) {
    header("Location: manage_students.php");
    exit;
}

$error_msg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $sql = "UPDATE student_admissions SET 
                admission_date=?, academic_year=?, class_applied=?, first_name=?, middle_name=?, last_name=?,
                dob=?, gender=?, student_email=?, student_phone=?, address=?, parent_name=?, parent_relation=?,
                parent_phone=?, parent_email=?, prev_school=?, prev_grade=?, prev_gpa=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("MySQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssssssssssssi",
        $admission_date, $academic_year, $class_applied, $first_name, $middle_name, $last_name,
        $dob, $gender, $student_email, $student_phone, $address, $parent_name,
        $parent_relation, $parent_phone, $parent_email, $prev_school, $prev_grade, $prev_gpa,
        $id
    );

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: manage_students.php?msg=updated");
        exit;
    } else {
        $error_msg = "Update Error: " . $stmt->error;
        $stmt->close();
    }
}

// Fetch existing record
$sql = "SELECT * FROM student_admissions WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Mahendra Maheshdev Secondary School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #f4f6f9; }
        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-header { text-align: center; margin-bottom: 2rem; }
        .form-header h1 { margin-bottom: 0.5rem; color: #2c3e50; }
        .form-section { margin-bottom: 1.5rem; }
        .section-title { font-size: 1.25rem; margin-bottom: 1rem; color: #2c3e50; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { margin-bottom: 0.5rem; font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea { padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
        .radio-checkbox-group { display: flex; gap: 1rem; }
        .radio-checkbox-label { display: flex; align-items: center; gap: 0.25rem; }
        .btn-container { display: flex; justify-content: flex-end; gap: 1rem; }
        .btn-container button { padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; }
        .btn-container a.cancel-btn { padding: 0.75rem 1.5rem; background-color: #ccc; color: #333; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-container button[type="submit"] { background-color: #2c3e50; color: #fff; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-header">
            <h1>Edit Student Record</h1>
        </div>

        <?php if (!empty($error_msg)): ?>
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <form action="edit_student.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">

            <div class="form-section">
                <div class="section-title">1. Academic Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="admission_date">Admission Date *</label>
                        <input type="date" id="admission_date" name="admission_date" value="<?php echo htmlspecialchars($student['admission_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="academic_year">Academic Year *</label>
                        <select id="academic_year" name="academic_year" required>
                            <option value="">-- Select Year --</option>
                            <option value="2026-2027" <?php if($student['academic_year'] == '2026-2027') echo 'selected'; ?>>2026-2027</option>
                            <option value="2027-2028" <?php if($student['academic_year'] == '2027-2028') echo 'selected'; ?>>2027-2028</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_applied">Class Applied *</label>
                        <select id="class_applied" name="class_applied" required>
                            <option value="">-- Select Class --</option>
                            <?php
                            $classes = ['nursery', 'lkg', 'ukg', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
                            foreach($classes as $c) {
                                $selected = ($student['class_applied'] == $c) ? 'selected' : '';
                                echo "<option value=\"$c\" $selected>" . ucfirst($c) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">2. Student Personal Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($student['middle_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth *</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Gender *</label>
                        <div class="radio-checkbox-group">
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="male" <?php if($student['gender'] == 'male') echo 'checked'; ?> required> Male</label>
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="female" <?php if($student['gender'] == 'female') echo 'checked'; ?>> Female</label>
                            <label class="radio-checkbox-label"><input type="radio" name="gender" value="other" <?php if($student['gender'] == 'other') echo 'checked'; ?>> Other</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">3. Contact &amp; Address Details</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="student_email">Student Email</label>
                        <input type="email" id="student_email" name="student_email" value="<?php echo htmlspecialchars($student['student_email']); ?>" placeholder="student@example.com">
                    </div>
                    <div class="form-group">
                        <label for="student_phone">Student Mobile</label>
                        <input type="tel" id="student_phone" name="student_phone" value="<?php echo htmlspecialchars($student['student_phone']); ?>" placeholder="+977 9XXXXXXXXX">
                    </div>
                    <div class="form-group full-width" style="grid-column: 1 / -1;">
                        <label for="address">Current Residential Address *</label>
                        <textarea id="address" name="address" rows="2" required><?php echo htmlspecialchars($student['address']); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">4. Parent / Guardian Information</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="parent_name">Parent/Guardian Full Name *</label>
                        <input type="text" id="parent_name" name="parent_name" value="<?php echo htmlspecialchars($student['parent_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_relation">Relationship to Student *</label>
                        <input type="text" id="parent_relation" name="parent_relation" value="<?php echo htmlspecialchars($student['parent_relation']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_phone">Mobile Number *</label>
                        <input type="tel" id="parent_phone" name="parent_phone" value="<?php echo htmlspecialchars($student['parent_phone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="parent_email">Parent Email Address</label>
                        <input type="email" id="parent_email" name="parent_email" value="<?php echo htmlspecialchars($student['parent_email']); ?>">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">5. Previous Academic History</div>
                <div class="form-grid">
                    <div class="form-group full-width" style="grid-column: 1 / -1;">
                        <label for="prev_school">Last School Attended</label>
                        <input type="text" id="prev_school" name="prev_school" value="<?php echo htmlspecialchars($student['prev_school']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="prev_grade">Highest Grade Completed</label>
                        <input type="text" id="prev_grade" name="prev_grade" value="<?php echo htmlspecialchars($student['prev_grade']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="prev_gpa">Grade Point Average (GPA)</label>
                        <input type="text" id="prev_gpa" name="prev_gpa" value="<?php echo htmlspecialchars($student['prev_gpa']); ?>">
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <a href="manage_students.php" class="cancel-btn">Cancel</a>
                <button type="submit">Update Record</button>
            </div>

        </form>
    </div>

</body>
</html>

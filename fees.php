<?php

if($_SERVER['REQUEST_METHOD'] =="POST"){

//db connection
    $servername = "localhost";
    $db_user    = "root";
    $db_pass    = "";
    $db_name    = "sms_db";

    $conn = new mysqli($servername, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

//collect data
  $student_name  = $_POST['student_name']  ?? '';
  $class = $_POST['class'] ?? '';
  $payer_name = $_POST['payer_name'] ?? '';
  $payer_email = $_POST['payer_email'] ?? '';
  $payer_relation = $_POST['payer_relation'] ?? '';
  $fee_type = $_POST['fee_type'] ?? '';
  $amount = $_POST['amount'] ?? 0;

      // ---- Insert into database ----
    $sql = "INSERT INTO fees (student_name, class, payers_name, payers_email, payers_relation, fee_type, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssd", $student_name, $class, $payer_name, $payer_email, $payer_relation, $fee_type, $amount);
    
    if ($stmt->execute()) {
        header("Location: pay_fees.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Fees Online</title>
        <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>

form {
    background: #ffffff;
    width: 100%;
    max-width: 600px;         /* CRITICAL: Prevents the form from stretching too wide */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Optional: Soft shadow to lift the card */
    margin: 0 auto;           /* Fallback centering alignment */
}


/* Form Container */
h2 {
    color: #1e293b;
    font-size: 2rem;
    margin-bottom: 4px;
    text-align: center;
}

.subtitle {
    color: #64748b;
    font-size: 1.5rem;
    text-align: center;
    margin-bottom: 25px;
}

/* Sections */
.form-section {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e2e8f0;
}

.form-section h3 {
    color: #2b6cb0; /* Professional Blue Accent */
    font-size: 16px;
    margin-bottom: 15px;
    font-weight: 600;
}

/* Inputs & Form Layout */


label {
    font-size: 1rem;
    color: #010c1d;
    font-weight: 500;
    margin-bottom: 6px;
}

input, select {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: 1rem;
    color: #334155;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

/* Input Focus States */
input:focus, select:focus {
    border-color: #2b6cb0;
    box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.15);
}

/* Button Styling */
.submit-btn {
    width: 100%;
    background-color: #2b6cb0;
    color: #ffffff;
    border: none;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s;
    margin-top: 10px;
}

.submit-btn:hover {
    background-color: #1a4f8a;
}

/* Responsive tweaks for smaller mobile screens */
@media (max-width: 480px) {
    .input-row {
        flex-direction: column;
        gap: 0;
    }
    .form-container {
        padding: 20px;
    }
}
    </style>
</head>
<body>
    <div id="public-view" class="view active-view">
          <div class="top-bar">
            <div class="contact-info">
                <i class="fa-solid fa-phone"></i> +977 9999999999
            </div>
            <div class="contact-info">
                <i class="fa-solid fa-envelope"></i> info@mahendramaheshdev.edu.np
            </div>
       <div class="date-info" id="date">
                <?php
                //date time logic
                    date_default_timezone_set('Asia/Kathmandu');

                    echo date('F j, Y g:i a'); 

                ?>
        </div>

        </div>

        <!-- Navbar -->
        <nav class="navbar">
            <a href="index.php">
                <div class="logo-container">
                    <img src="assets/logo.png" alt="Logo" class="logo-img">
                    <div class="logo-text">
                        <h1>Mahendra Maheshdev</h1>
                        <p>Secondary School</p>
                    </div>
                </div>
            </a>


            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="admissions.php">Admissions</a></li>
                <li><a href="academics.php">Academics</a></li>
                <li><a href="team.php">Team</a></li>
                <li><a href="notices.php" class="active">Notices and Results</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>


            <!-- Main Content Area -->
        <main class="public-main">
            <section class="page-header"
                style="text-align: center; padding: 4rem 2rem; background: var(--secondary-color, #f4f7f6); border-radius: 8px; margin: 2rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Pay Fees Online
                </h2>
                <p style="font-size: 1.1rem; color: #666;">Pay fees online!</p>
            </section>
        </main>

        <div class="form-container">
        <h2>Online Fee Payment</h2>
        <p class="subtitle">Mahendra Maheshdev Secondary School</p>
        
        <form action="fees.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-section">
                <h3 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Student Information</h3>
                
                <div class="form-group">
                    <label for="student-name">Full Name *</label>
                    <input type="text" id="student-name" name="student_name" placeholder="E.g., Ram Thapa" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="student-id">Student ID / Roll No *</label>
                        <input type="text" id="student-id" name="student_id" placeholder="E.g., MMSS-2026-45" required>
                    </div>
                    <div class="form-group">
                        <label for="class">Class/Grade</label>
                        <select id="class" name="class" required>
                        <option value="" disabled selected>Select Class</option>
                        <option value="class 9 G">Class 9 General</option>
                        <option value="class 10 G">Class 10 General</option>
                        <option value="class 11 G">Class 11 Management</option>
                        <option value="class 12 G">Class 12 Management</option>
                         <option value="class 9 T">Class 9 Technical</option>
                        <option value="class 10 T">Class 10 Technical</option>
                        <option value="class 11 E">Class 11 Education</option>
                        <option value="class 12 E">Class 12 Education</option>
                        <option value="class 11 T">Class 11 Technical</option>
                        <option value="class 12 T">Class 12 Technical</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="form-seciton">
                <h3 style="font-size: 1.5rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Payer's Information</h3>
                <label for="payer-name">Payer's Full Name *</label>
                    <input type="text" id="payer-name" name="payer_name" placeholder="E.g., Ram Thapa" required>
                <label for="payer-email">Payer's Email *</label>
                    <input type="email" id="payer-email" name="payer_email" placeholder="E.g., ram.thapa@example.com" required>
                <label for="payer-relation">Payer's Relation to Student *</label>
                    <input type="text" id="payer-relation" name="payer_relation" placeholder="E.g., Father, Mother, Guardian" required>
            </div><br>
            <div class="form-section">
                <h3 style="font-size: 1.25rem; color: var(--primary-color, #2c3e50); margin-bottom: 1rem;">Payment Details</h3>
                
                <div class="input-group">
                    <label for="fee-type">Fee Type *</label>
                    <select id="fee-type" name="fee_type" required>
                        <option value="" disabled selected>Select fee type</option>
                        <option value="tuition">Tuition Fee</option>
                        <option value="examination">Examination Fee</option>
                        <option value="transport">Transport Fee</option>
                        <option value="admission">New Admission Fee</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="amount">Amount to Pay (NPR) *</label>
                    <input type="number" id="amount" name="amount" min="100" placeholder="Enter amount" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">Proceed to Pay</button>
            
        </form>
    </div>
        <script src="script.js"></script>
</body>
</html>
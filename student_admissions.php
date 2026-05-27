<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissioin of Student</title>
        <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
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

    </style>
</head>
<body>
        <div class="form-container">
    <div class="form-header">
        <h1>Student Admission Form</h1>
               <div class="logo-container">
                <img src="assets/logo.png" alt="Logo" class="logo-img">
                <div class="logo-text">
                    <h1 style="font-size: 1.5rem;">Mahendra Maheshdev Secondary School</h1>
                    <p style="font-size: 1.2rem;">Likhu-6, Nuwakot, Nepal</p>
                    
                </div>
    </div>
    </div>

    <form action="#" method="POST">
        
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
            <div class="section-title">3. Contact & Address Details</div>
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
                    <label for="parent_phone">Mobile Number*</label>
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
                    <label for="prev_gpa">Grade Point Average GPA</label>
                    <input type="text" id="prev_gpa" name="prev_gpa" require>
                </div>
                <div class="form-group">
                    <label for="birth_certificate">Birth Certificate Image*</label>
                    <input type="file" id="birth_certificate" name="birth_certificate" required>
                </div>
                <div class="form-group">
                    <label for="marksheet">Marksheet Photo of previous academic year*</label>
                    <input type="file" id="marksheet" name="marksheet" required>
                </div>
            </div>
        </div>

        <div class="declaration-box">
            I hereby declare that the information provided above is true and accurate to the best of my knowledge. I understand that any false statements may result in the cancellation of admission.
        </div>

        <div class="btn-container">
            <button type="reset">Reset Form</button>
            <button type="submit">Submit Application</button>
        </div>

    </form>
</div>
    
</body>
</html>
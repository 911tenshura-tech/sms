<?php
session_start();
require_once '../connection/db.php';

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        if (!isset($pdo)) {
            $error_msg = "Database connection failed. Please ensure the database server is running and configured correctly.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
                $stmt->execute([':username' => $username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin && password_verify($password, $admin['password'])) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $admin['username'];
                    header("Location: admin.php");
                    exit;
                } else {
                    $error_msg = "Invalid username or password!";
                }
            } catch (PDOException $e) {
                $error_msg = "Database error: " . $e->getMessage();
            }
        }
    } else {
        $error_msg = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mahendra Maheshdev Secondary School</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css?v=1.2">
    <style>
        body {
            background-color: var(--sidebar-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .login-container {
            background: var(--bg-white);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-logo {
            width: 80px;
            margin-bottom: 20px;
        }
        .login-container h2 {
            color: var(--primary-color);
            margin-bottom: 5px;
            font-size: 1.5rem;
        }
        .login-container p {
            color: var(--text-muted);
            margin-bottom: 30px;
            font-size: 0.9rem;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30,86,179,0.1);
            outline: none;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-btn:hover {
            background: var(--primary-light);
        }
        .alert {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 0.9rem;
            color: var(--primary-color);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="../assets/logo.png" alt="Logo" class="login-logo">
        <h2>Admin Portal</h2>
        <p>Sign in to admin dashboard</p>

        <?php if(!empty($error_msg)): ?>
            <div class="alert"><i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error_msg); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter password">
            </div>
            <button type="submit" class="login-btn"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
        </form>
        <a href="index.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Public Site</a>
    </div>

</body>
</html>

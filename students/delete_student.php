<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // DB connection
    $servername = "localhost";
    $db_user    = "root";
    $db_pass    = "";
    $db_name    = "sms_db";

    $conn = new mysqli($servername, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM student_admissions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manage_students.php?msg=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: manage_students.php");
}
?>

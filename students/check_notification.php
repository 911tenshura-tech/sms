<?php
header('Content-Type: application/json');

// Connect to Database
$conn = new mysqli("localhost", "root", "", "sms_db");
if ($conn->connect_error) { 
    echo json_encode(['unread_count' => 0]);
    exit;
}

// Count only unread applications
$result = $conn->query("SELECT COUNT(*) AS unread_cnt FROM student_admissions WHERE status = 'unread'");
$row = $result->fetch_assoc();

echo json_encode([
    'unread_count' => (int)$row['unread_cnt']
]);

$conn->close();
?>
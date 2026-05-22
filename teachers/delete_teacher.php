<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once '../connecion/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        // Fetch current details to delete the image file
        $stmt = $pdo->prepare("SELECT t_image FROM teachers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($teacher) {
            // Delete the physical profile image if it exists
            if (!empty($teacher['t_image']) && file_exists('assets/uploads/teachers/' . $teacher['t_image'])) {
                unlink('assets/uploads/teachers/' . $teacher['t_image']);
            }

            // Delete database record
            $deleteStmt = $pdo->prepare("DELETE FROM teachers WHERE id = :id");
            $deleteStmt->execute([':id' => $id]);
        }
    } catch (PDOException $e) {
        // Log or handle the exception quietly or gracefully
    }
}

header("Location: teachers.php?msg=deleted");
exit;
?>

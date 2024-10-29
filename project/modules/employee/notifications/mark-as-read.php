<?php
// Include database connection and start session
include('../../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notification_id = $_POST['notification_id'];

    // Update the notification to mark it as read
    $query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();

    header('Location: notifications.php');
}
?>

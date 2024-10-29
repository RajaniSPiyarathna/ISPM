<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $policy_id = $_POST['policy_id'];
    $employee_id = $_SESSION['user_id'];

    // Insert acknowledgement into database
    $query = "INSERT INTO policy_acknowledgements (policy_id, employee_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $policy_id, $employee_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Policy acknowledged successfully!";
    } else {
        $_SESSION['error'] = "Error acknowledging policy.";
    }

    header("Location: policies.php");
}

<?php
function logEvent($conn, $eventType, $userId, $status, $message) {
    // Capture the user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Convert '::1' (IPv6 localhost) to '127.0.0.1' for consistency
    if ($ip_address == '::1') {
        $ip_address = '127.0.0.1';
    }
    
    // Prepare an SQL statement for logging events with the IP address
    $query = "INSERT INTO event_logs (event_type, user_id, status, message, ip_address, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters (event_type, user_id, status, message, ip_address)
        $stmt->bind_param("sisss", $eventType, $userId, $status, $message, $ip_address);
        
        // Execute the statement
        if (!$stmt->execute()) {
            // Handle the case where execution fails
            error_log("Failed to log event: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the case where statement preparation fails
        error_log("Failed to prepare statement: " . $conn->error);
    }
}
?>


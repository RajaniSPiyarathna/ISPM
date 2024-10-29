<?php
// Include database connection
include('../../../config/config.php');

// Define retention policy (delete logs older than 90 days)
$retention_period = '90 DAY';

// Query to delete old logs
$delete_query = "DELETE FROM logs WHERE timestamp < NOW() - INTERVAL $retention_period";
if ($conn->query($delete_query) === TRUE) {
    echo "Old logs deleted successfully.";
} else {
    echo "Error deleting logs: " . $conn->error;
}
?>

<?php
// Database connection configuration

$host = 'localhost';        
$dbname = 'leco';   
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 for proper encoding
$conn->set_charset("utf8");

?>


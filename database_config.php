<?php

$servername =   "127.0.0.1";
$username   =   "root";
$password   =   "secret";
$database   =   "quantox_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

return $conn;

?>

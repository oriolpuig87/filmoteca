<?php
$servername = "localhost";
$username = "peliteca";
$password = "pel#1997";
$dbname = "pelisteca";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
<?php
//You can change this to your server settings
//You can go to the db_config folder in the includes directory
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tlauth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?> 
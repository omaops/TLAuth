<?php
//This is your database connection string data

//You can change this to your server settings
//You can go to the db_config folder in the includes directory to see the create.sql file you need to create the table(s) inside the database

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

<?php
//
$servername = "localhost";
$username = "root";
$password = "";
// $dbname needs to be changed before staging
$dbname = "food_db_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

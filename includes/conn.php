<?php

// Connect to the database
$host = "localhost";
$username = "aiiovdft_health";
$password = "Marvelyiky";
$dbname = "aiiovdft_health";


$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
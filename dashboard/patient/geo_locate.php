<?php

// Connect to MySQL database
include("../../includes/conn.php");

// Retrieve user from request
$user = mysqli_real_escape_string($conn, $_GET['user']);

// Query to retrieve geolocation API key for specific user
$sql = "SELECT geo_api FROM users WHERE user='$user'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Return API key as JSON
    $row = mysqli_fetch_assoc($result);
    echo json_encode(array('geo_api' => $row['geo_api']));
} else {
    // Return error if no API key found for user
    echo json_encode(array('error' => 'No API key found for user.'));
}

// Close connection
mysqli_close($conn);

?>

<?php

// Connect to the MySQL database
include("../../includes/conn.php");

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $searchName = mysqli_real_escape_string($conn, $_POST['searchName']);


    $query = "SELECT * FROM patients WHERE Name = '$searchName'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {

        $response = array('message' => 'No patient in database. Try to another name.');
    } else {
        $query = "SELECT * FROM patients WHERE Name = '$searchName'";
        $result = mysqli_query($conn, $query);
        $patient = mysqli_fetch_assoc($result);

        $response = array('patient' => array($patient));
    }

    // Set the response header to JSON and echo the response
    header('Content-Type: application/json');
    echo json_encode($response);
} else echo "searchName failed";


// Close the MySQL connection
mysqli_close($conn);

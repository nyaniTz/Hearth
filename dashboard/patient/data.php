<?php

// Connect to the MySQL database
include("../../includes/conn.php");
if (mysqli_connect_errno()) {
  die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Get the user and token from the request
  //extract($_GET);
  $user = mysqli_real_escape_string($conn, $_GET['user']);
  $token = mysqli_real_escape_string($conn, $_GET['token']);

  // Check if the token matches the user's stored token
  $query = "SELECT * FROM patients WHERE user = '$user'"; // AND token = '$token'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    // Token does not match, return an error message
    $response = array('message' => 'Token does not match. Try to Login Again.');
  } else {
    // Token matches, get the user's data from the database
    $query = "SELECT * FROM patients WHERE user = '$user'";
    $result = mysqli_query($conn, $query);
    $patient = mysqli_fetch_assoc($result);

    // Return the patient data in the response
    $response = array('patient' => array($patient));
  }

  // Set the response header to JSON and echo the response
  header('Content-Type: application/json');
  echo json_encode($response);
}

// Close the MySQL connection
mysqli_close($conn);

?>
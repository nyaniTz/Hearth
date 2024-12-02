<?php

// Connect to the MySQL database
include("../../includes/conn.php");

// Get the event data from the POST request
$eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
$startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
$endDate = mysqli_real_escape_string($conn, $_POST['endDate']);

// Insert the event data into the MySQL database
$sql = "INSERT INTO events (event_name, start_date, end_date) VALUES ('$eventName', '$startDate', '$endDate')";
if (mysqli_query($conn, $sql) ){
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
  // Close the MySQL connection
  mysqli_close($conn);

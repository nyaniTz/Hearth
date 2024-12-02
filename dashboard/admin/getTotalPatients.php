<?php
// Assuming you have a database connection established
include("../../includes/conn.php");

// Retrieve the necessary data based on the doctorName parameter
$doctorName = $_POST['doctorName'];

// Query to retrieve the total appointments for the selected doctor (all time)
$queryAllTime = "SELECT COUNT(*) AS doctor_id FROM appointments WHERE appointment_status = 'confirmed' AND doctor_id = '$doctorName'";
$resultAllTime = mysqli_query($conn, $queryAllTime);
$rowAllTime = mysqli_fetch_assoc($resultAllTime);
$totalAppointmentsAllTime = $rowAllTime['doctor_id'];

// Query to retrieve the total appointments for the selected doctor (today)
$currentDate = date("Y-m-d");
$queryToday = "SELECT COUNT(*) AS doctor_id FROM appointments WHERE appointment_status = 'confirmed' AND doctor_id = '$doctorName' AND DATE(created_at) = '$currentDate'";
$resultToday = mysqli_query($conn, $queryToday);
$rowToday = mysqli_fetch_assoc($resultToday);
$totalAppointmentsToday = $rowToday['doctor_id'];



$currentDate1 = date("Y-m-d");
$queryToday1 = "SELECT COUNT(*) AS doctor_id FROM appointments WHERE appointment_status = 'pending' AND doctor_id = '$doctorName' AND DATE(created_at) = '$currentDate1'";
$resultToday1 = mysqli_query($conn, $queryToday1);
$rowToday1 = mysqli_fetch_assoc($resultToday1);
$totalAppointmentsToday1 = $rowToday1['doctor_id'];



$currentDate1 = date("Y-m-d");
$queryToday1 = "SELECT COUNT(*) AS doctor_id FROM appointments WHERE appointment_status = 'pending' AND doctor_id = '$doctorName' AND DATE(created_at) = '$currentDate1'";
$resultToday1 = mysqli_query($conn, $queryToday1);
$rowToday1 = mysqli_fetch_assoc($resultToday1);
$totalAppointmentsToday1 = $rowToday1['doctor_id'];


$currentDate = date("Y-m-d");
$query = "SELECT COUNT(DISTINCT service_type) AS service_count FROM appointments
 
          WHERE appointment_status = 'confirmed' AND doctor_id = '$doctorName' AND DATE(created_at) = '$currentDate'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalServices = $row['service_count'];


$query1 = "SELECT COUNT(DISTINCT service_type) AS service_count FROM appointments
 
          WHERE appointment_status = 'confirmed' AND doctor_id = '$doctorName' ";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);
$totalServicesAlltheTime = $row1['service_count'];





// Create an associative array with the data
$response = array(
  'allTime' => $totalAppointmentsAllTime,
  'today' => $totalAppointmentsToday,
  'todaypending' => $totalAppointmentsToday1,
  'service_count' => $totalServices,
  'service_countAllTime' => $totalServicesAlltheTime 


);

// Convert the array to JSON format
$jsonResponse = json_encode($response);

// Return the JSON response
echo $jsonResponse;


?>

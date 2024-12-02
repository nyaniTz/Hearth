<?php

// Connect to the database
include("../includes/conn.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the form data from the AJAX request
$data = json_decode(file_get_contents('php://input'), true);

// Extract the patient data from the form data
$patient = $data['newpatient'];

// Prepare the SQL statement to insert the patient data into the database
$sql = "INSERT INTO patients (Name, Address, Age, Ambulation, BMI, Chills, Contacts, DOB, Email, DBP, DecreasedMood, FiO2, GeneralizedFatigue, HeartRate, HistoryFever, RR, RecentHospitalStay, SBP, SpO2, Temp, WeightGain, WeightLoss, BGroup, Sex, pass, user)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Put user in users table
$uu = $patient['user'];
$pp = $patient['pass'];
mysqli_query($conn, "INSERT INTO `users` (`user`, `pass`, `geo_api`, `lat`, `lon`, `token`, `status`) VALUES ( '$uu', '$pp','45d6937ff6b14b1a9bf1d4aa6f9a26a5', 37.4419, -122.142, 'token1','patient') ");




$stmt = mysqli_prepare($conn, $sql);


// Bind the values to the SQL statement
mysqli_stmt_bind_param($stmt, "ssiiiiissiiiiisisiiiiissss", 
    $patient['Name'], $patient['Address'], $patient['Age'], $patient['Ambulation'], $patient['BMI'], $patient['Chills'], $patient['Contacts'], $patient['DOB'], $patient['Email'], $patient['DBP'], $patient['DecreasedMood'], $patient['FiO2'], $patient['GeneralizedFatigue'], $patient['HeartRate'], $patient['HistoryFever'], $patient['RR'], $patient['RecentHospitalStay'], $patient['SBP'], $patient['SpO2'], $patient['Temp'], $patient['WeightGain'], $patient['WeightLoss'], $patient['BGroup'], $patient['Sex'], $patient['pass'], $patient['user']);




// Execute the SQL statement
if (mysqli_stmt_execute($stmt) ) {
    // Return a success message if the query was successful
    echo json_encode(array('status' => 'success'));
} else {
    // Return an error message if the query failed
    echo json_encode(array('status' => 'error', 'message' => mysqli_error($conn)));
}

// Close the connection
mysqli_close($conn);

?>
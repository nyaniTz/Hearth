<?php
include("../../includes/conn.php");
// Get the patient ID from the GET request
$patID = $_GET['patID'];

// Read the raw data from the request body
$data = file_get_contents("php://input");

// Decode the JSON data
$patientData = json_decode($data, true);

// Connect to the database
$db = $conn;

// Check if the connection was successful
if ($db->connect_error) {
    // If the connection failed, return an error message
    http_response_code(500);
    echo "Failed to connect to the database: " . $db->connect_error;
    exit();
}

// Build the update query
$query = "UPDATE patients SET ";
$query .= "SBP = '" . $patientData['patientData']['SBP'] . "', ";
$query .= "DBP = '" . $patientData['patientData']['DBP'] . "', ";
$query .= "HeartRate = '" . $patientData['patientData']['HeartRate'] . "', ";
$query .= "RR = '" . $patientData['patientData']['RR'] . "', ";
$query .= "SpO2 = '" . $patientData['patientData']['SpO2'] . "', ";
$query .= "Temp = '" . $patientData['patientData']['Temp'] . "', ";
$query .= "FiO2 = '" . $patientData['patientData']['FiO2'] . "' ";
$query .= "WHERE ID = '" . $patID . "'";

// Run the update query
$result = $db->query($query);

// Check if the query was successful
if ($result) {
    // If the query was successful, return a success message
    http_response_code(200);
    echo "Patient data updated successfully";
} else {
    // If the query failed, return an error message
    http_response_code(500);
    echo "Failed to update patient data: " . $db->error;
}

// Close the database connection
$db->close();

?>

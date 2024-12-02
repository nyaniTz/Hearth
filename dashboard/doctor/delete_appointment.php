<?php
// Assuming you have already established a database connection

include('../../includes/conn.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the appointment ID from the request
$appointmentID = $_POST['appointmentID'];

// Delete the appointment record from the database
$sql = "DELETE FROM appointments WHERE appointment_id = '$appointmentID'";

if ($conn->query($sql) === true) {
    // Appointment record deleted successfully
    $response = array('status' => 'success', 'message' => 'Appointment deleted successfully');
} else {
    // Failed to delete the appointment record
    $response = array('status' => 'error', 'message' => 'Failed to delete the appointment');
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

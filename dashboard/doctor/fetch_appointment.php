<?php
// Assuming you have already established a database connection

include('../../includes/conn.php');
// Fetch the appointment records from the database
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

// Prepare the response array
$response = array();
$response['appointments'] = array();

// Check if any appointments were found
if ($result->num_rows > 0) {
    // Iterate through the rows and fetch the appointment data
    while ($row = $result->fetch_assoc()) {
        // Prepare the appointment object
        $appointment = array(
            'appointment_id' => $row['appointment_id'],
            'patient_id' => $row['patient_id'],
            'doctor_id' => $row['doctor_id'],
            'appointment_date' => $row['appointment_date'],
            'appointment_time' => $row['appointment_time'],
            'service_type' => $row['service_type'],
            'service_description' => $row['service_description'],
            'appointment_status' => $row['appointment_status']
        );

        // Add the appointment to the response array
        $response['appointments'][] = $appointment;
    }
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

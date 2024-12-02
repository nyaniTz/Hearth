<?php
// Assuming you have already established a database connection

include('../../includes/conn.php');

// Get the appointment data from the request
$appointmentID = $_POST['appointmentID'];
$patientID = $_POST['patientID'];
$doctorID = $_POST['doctorID'];
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = $_POST['appointmentTime'];
$serviceType = $_POST['serviceType'];
$serviceDescription = $_POST['serviceDescription'];
$appointmentStatus = $_POST['appointmentStatus'];

//Add code here



// Update the appointment record in the database
$sql = "UPDATE appointments SET
        patient_id = '$patientID',
        doctor_id = '$doctorID',
        appointment_date = '$appointmentDate',
        appointment_time = '$appointmentTime',
        service_type = '$serviceType',
        service_description = '$serviceDescription',
        appointment_status = '$appointmentStatus'
        WHERE appointment_id = '$appointmentID'";

if ($conn->query($sql) === true) {
    // Appointment record updated successfully
    
                // Query parameters
            $params = array(
                'appointID' => $appointmentID,
                'appointDateTime' => $appointmentDate.' '.$appointmentTime,
            );
            
            // Build the query string
            $queryString = http_build_query($params);
            
            // URL of the target PHP file
            $url = '../../api/main.php?' . $queryString;
            $response2 = file_get_contents($url);
    
    
    $response = array('status' => 'success', 'message' => 'Appointment updated successfully '.$response2);
} else {
    // Failed to update the appointment record
    $response = array('status' => 'error', 'message' => 'Failed to update the appointment');
}

// Close the database connection
$conn->close();

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

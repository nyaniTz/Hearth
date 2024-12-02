<?php
// connect to database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// retrieve form data
$patient_id = $_POST["patient_id"];
$doctor_id = $_POST["doctor_id"];
$appointment_date = $_POST["appointment_date"];
$appointment_time = $_POST["appointment_time"];
$service_type = $_POST["service_type"];
$service_description = $_POST["service_description"];

// insert new appointment into database
$sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, service_type, service_description, appointment_status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $patient_id, $doctor_id, $appointment_date, $appointment_time, $service_type, $service_description);
if ($stmt->execute()) {
    echo "Appointment successfully scheduled!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// close database connection
$conn->close();
?>

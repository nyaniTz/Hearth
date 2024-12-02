<?php
// Connect to the MySQL database
include("../../includes/conn.php");

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Check if the appointmentId parameter is set
if (isset($_POST['appointmentId'])) {


    $appointmentId = $_POST['appointmentId'];

    echo $appointmentId;

    // Perform the delete operation
    $sql = "DELETE FROM `appointments` WHERE `appointment_id` = '$appointmentId' ";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        // Deletion successful
        echo "Appointment deleted";
    } else {
        // Failed to delete appointment
        echo "Error deleting appointment: " . $conn->error;
    }

    $conn->close();
}
?>

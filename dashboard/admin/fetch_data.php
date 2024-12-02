<?php
include("../../includes/conn.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM `appointments` WHERE appointment_id='$id'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and fetch the data
    if ($result && mysqli_num_rows($result) > 0) {
        $appointmentData = mysqli_fetch_assoc($result);

        // Close the database connection
        mysqli_close($conn);

        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode($appointmentData);
        exit();
    } else {
        // No appointment found with the specified ID
        // Handle the error case
        echo "No appointment found";
        exit();
    }
} else {
    // No 'id' parameter provided
    // Handle the error case
    echo "No 'id' parameter provided";
    exit();
}
?>

<?php

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $report_id = $_POST['report_id'];

    $query = "
            SELECT filename, doctor_email, patient_id from reports 
            WHERE report_id = '$report_id'
        ";

    $result = mysqli_query($conn,$query);

    $reports = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($reports);

?>
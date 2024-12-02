<?php

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $report_id = $_POST['report_id'];
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $patient_name = $_POST['patient_name'];
    $filename = $_POST['filename'];
    $report_type = $_POST['report_type'];
    $doctor_email = $_POST['doctor_email'];
    $status = $_POST['status'];
    $created_date = $_POST['created_date'];

    $query = "
            INSERT INTO `reports`(`report_id`, `patient_id`, `doctor_id`, `patient_name` ,`filename`, `report_type`, `doctor_email`, `status`, `created_date`) 
            VALUES ('$report_id','$patient_id','$doctor_id','$patient_name','$filename','$report_type','$doctor_email','$status','$created_date')
        ";

    $result = mysqli_query($conn,$query);

    if($result) echo "success";

?>
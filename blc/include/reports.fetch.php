<?php

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $field_name = $_POST['field_name'];
    $field_value = $_POST['field_value'];
    $status = $_POST['status'];

    $query = "
            SELECT * from reports 
            WHERE $field_name = '$field_value' AND status = '$status'
        ";

    $result = mysqli_query($conn,$query);

    $reports = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($reports);

?>
<?php

    include "db-connect.script.php"; 

    $conn = OpenConnection();

    $id= $_POST['id'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "
        SELECT *
        FROM `cancer_results` WHERE id = '$id'
    ";

    $result = mysqli_query($conn,$query);

    $cancerRecord = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($cancerRecord);

?>
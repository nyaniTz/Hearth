<?php

    include "db-connect.script.php"; 

    $conn = OpenConnection();

    $userID = $_POST['userID'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "
        SELECT *
        FROM `cancer_results` WHERE user_id = '$userID'
    ";

    $result = mysqli_query($conn,$query);

    $cancerRecords = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($cancerRecords);

?>
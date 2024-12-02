<?php

    include "db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_POST['id'];
    $userID = $_POST['userID'];
    $imageName = $_POST['imageName'];
    $result = $_POST['result'];

    $query = "
        INSERT INTO `cancer_results`(`user_id`, `id`, `result`, `image`) 
        VALUES ('$userID','$id','$result','$imageName')
    ";

    $result = mysqli_query($conn,$query);

    if($result) echo $id;

?>
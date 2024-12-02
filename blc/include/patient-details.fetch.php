<?php

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $id = $_POST['id'];

    $query = "
            SELECT * from patients WHERE ID = '$id'
            ORDER BY Name ASC
        ";

    $result = mysqli_query($conn,$query);

    $user = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($user);

?>
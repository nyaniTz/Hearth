<?php

    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "aiiovdft_health";

    $id = $_POST['id'];
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "
            SELECT * from patients WHERE ID = '$id'
            ORDER BY Name ASC
        ";

    $result = mysqli_query($conn,$query);

    $user = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($user);

?>
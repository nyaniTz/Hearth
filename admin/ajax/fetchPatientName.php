<?php

    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "aiiovdft_health";

    $Name = $_POST['Name'];
    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "
    SELECT ID, Name from patients WHERE Name REGEXP '$Name'
    ORDER BY Name ASC
    ";

    $result = mysqli_query($conn,$query);

    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);

    echo json_encode($users);

?>
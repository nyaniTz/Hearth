<?php

    $host = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "aiiovdft_health";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset( $_POST['firstname']) && isset( $_POST['lastname'])){
        $firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn,$_POST['lastname']);

        echo "You name is: " . $_POST['firstname'] . " ". $_POST['lastname'];

        $query = "INSERT INTO ajaxtable(firstname,lastname) values('$firstname','$lastname')";

        if(mysqli_query($conn,$query)){
            echo "User Added";
        }
        else{
            echo "Error: " . mysqli_error($conn); 
        }
    }

?>
<?php

    include "../include/db_connect.php"; 

    $conn = OpenConnection();

    // if($conn){
    //     echo "Connection Successful\n";
    // }
    // else {
    //     echo "Connection Unsuccessful\n";
    // }
   
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $age = $_POST["age"];
    $license = $_POST["license"];
    $phone = $_POST["phone"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

    $register = "
	INSERT INTO doctors (firstname,lastname,age,phone,license,gender,address) 
		values ('$firstname','$lastname','$age','$phone','$license','$gender','$address')
    ";

	mysqli_query($conn, $register); //check if it was successful

    echo "New Doctor Added";

    CloseConnection($conn);

?>
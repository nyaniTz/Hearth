<?php

    session_start();
    
    include "../include/db_connect.php"; 

    $conn = OpenConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $select_query = " 
		SELECT username,email 
		FROM admins
		WHERE (username = '$username' OR email = '$username') && password = '$password'
	";

    $result = mysqli_query($conn,$select_query);
    $row = mysqli_fetch_array($result);

    CloseConnection($conn);
    
    if(mysqli_num_rows($result) == 1){ //sizeof row

        $_SESSION['username'] = $row[0];
        $_SESSION['email'] = $row[1];

        header('location:../');
    }
    else{
        header('location:index.php');
    }

?>

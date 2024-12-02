<?php

session_start();

include "health-db-connect.script.php"; 

$conn = OpenConnection();

$username = $_POST['doctor-username'];
$password = $_POST['doctor-password'];

$select_query = " 
    SELECT id, username, firstname, lastname, email
    FROM doctors WHERE username = '$username' && password = '$password'
";

$result = mysqli_query($conn,$select_query);
$row = mysqli_fetch_array($result);

CloseConnection($conn);

if(mysqli_num_rows($result) == 1){ //sizeof row

    $_SESSION['doctor-id'] = $row[0];
    $_SESSION['doctor-username'] = $row[1];
    $_SESSION['doctor-fullname'] = "$row[2] $row[3]";
    $_SESSION['doctor-email'] = $row[4];
    header('location:./../');
}
else{
    header('location:./../login.php');
}

?>

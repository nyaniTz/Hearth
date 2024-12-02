<?php

session_start();

include "health-db-connect.script.php"; 

$conn = OpenConnection();

$username = $_POST['patient-username'];
$password = $_POST['patient-password'];

$select_query = " 
    SELECT user, Email, ID
    FROM patients
    WHERE (user = '$username' OR Email = '$username') && pass = '$password'
";

$result = mysqli_query($conn,$select_query);
$row = mysqli_fetch_array($result);

CloseConnection($conn);

if(mysqli_num_rows($result) == 1){ //sizeof row

    $_SESSION['patient-username'] = $row[0];
    $_SESSION['patient-email'] = $row[1];
    $_SESSION['patient-id'] = $row[2];

    header('location:./../');
}
else{
    header('location:./../login.php');
}

?>

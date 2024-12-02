<?php

    session_start();

    if(isset($_SESSION['username'])){
        header('location:../');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <form class="login-form" action="login.php" method="POST">
        <span class="logo">
            <img src="../assets/logo-blue.png" alt="">
        </span>

        <h1 class="login-form-title">Admin Login</h1>

        <div class="input-container">
            <span class="input-label">Username</span>
            <input name="username" class="input-field" type="text" class="login-username" placeholder="Username">
        </div>

        <div class="input-container">
            <span class="input-label">Password</span>
            <input name="password" class="input-field" type="password" class="login-password" placeholder="Password">
        </div>

        <button class="login-button" type="submit">Log In</button>
    </form>
</body>
</html>
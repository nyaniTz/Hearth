<?php

  session_start();
  if(isset($_SESSION['patient-username'])){
    header('location:./');
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <section id="patient-login">
      <div class='inner-section-container'>
        <form class="login-form patient" action="./include/login-patient.script.php" method="POST">
          <h1 class="login-form-title">Report Login <nl>Patients</nl></h1>

          <div class="input-container">
          <input name="patient-username" class="input-field" type="text" class="login-username" placeholder="Username">
          <input name="patient-password" class="input-field" type="password" class="login-password" placeholder="Password">
          </div>

          <button class="login-button" type="submit">Log In</button>
        </form>
        <div class='element-link orange'>Are you a doctor? <a href="#doctor-login">Click Here</a></div>
      </div>
    </section>
    
    <section id="doctor-login">
      <div class='inner-section-container'>
        <form class="login-form doctor" action="./include/login-doctor.script.php" method="POST">
            <h1 class="login-form-title">Report Login <nl>Doctors</nl></h1>

            <div class="input-container">
            <input name="doctor-username" class="input-field" type="text" class="login-username" placeholder="Username">
            <input name="doctor-password" class="input-field" type="password" class="login-password" placeholder="Password">
            </div>

            <button class="login-button" type="submit">Log In</button>
        </form>
        <div class='element-link green'>Are you a patient? <a href="#patient-login">Click Here</a></div>
      </div>
    </section>
    
</body>
</html>
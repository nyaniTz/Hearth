<?php
  session_start();

  $isPatient = isset($_SESSION['patient-username']);
  $isDoctor = isset($_SESSION['doctor-username']);

  if($isPatient && !$isDoctor){ include 'patient.php'; }
  else if($isDoctor && !$isPatient){ include 'doctor.php'; }
  else if($isDoctor && $isPatient){ header('location:./logout.php'); }
  else{ header('location:./login.php'); }
?>
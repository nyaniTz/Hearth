<?php

   function OpenConnection(){
      
      $host = "localhost";
      $username = "aiiovdft_health";
      $password = "Marvelyiky";
      $dbname = "aiiovdft_health";
      
      $conn = new mysqli($host, $username, $password, $dbname) or die("Connection to database failed: %s\n". $conn -> error);

      return $conn;
   }
 
   function CloseConnection($conn){
      $conn -> close();
   }
?>
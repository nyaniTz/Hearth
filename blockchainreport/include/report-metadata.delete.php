<?php 

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $report_id = $_POST['report_id'];

    $query = "
            DELETE FROM reports WHERE report_id = '$report_id'
        ";

    $result = mysqli_query($conn,$query);    
    if( $result ){
        echo "record deleted";
    }else{
        echo "error";
    }  

?>

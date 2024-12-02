<?php 

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $report_id = $_POST['report_id'];

    $query = "
            UPDATE reports
            SET status = 'blockchain'
            WHERE report_id = '$report_id';
        ";

    $result = mysqli_query($conn,$query);    
    if( $result ){
        echo "record on blockchain";
    }else{
        echo "error";
    }  

?>

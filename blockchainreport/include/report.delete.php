<?php 

    include "health-db-connect.script.php"; 

    $conn = OpenConnection();

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $report_id = $_POST['report_id'];
    $file_name_path = $_POST['file_name_path'];

    $query = "
            DELETE FROM reports WHERE report_id = '$report_id'
        ";

    $result = mysqli_query($conn,$query);

    $status = unlink($file_name_path);    
    
    if( $status && $result ){  
        echo "file and record deleted";    
    }elseif( $result ){
        echo "record deleted";
    }elseif( $status ){
        echo "file deleted";
    }  

?>

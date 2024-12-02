<?php
include("../includes/conn.php");
$username = $_GET['user'];
$password = $_GET['pass'];
$latitude = 35.02124; //$_GET['lat'];
$longitude = 33.25457; //$_GET['lng'];
// Connect to database

// function console_log($output, $with_script_tags = true) {
//     $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
// ');';
//     if ($with_script_tags) {
//         $js_code = '<script>' . $js_code . '</script>';
//     }
//     echo $js_code;
// }


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if username and password match a user in the database
$sql = "SELECT * FROM patients WHERE user='$username' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Get the "status" field value from the first row of the result set
    $row = mysqli_fetch_assoc($result);
    $status = $row['status'];
    // Prepare the SQL statement with placeholders for the parameters
    $stmt = mysqli_query($conn, "UPDATE patients SET latitude = '".$latitude."', longitude = '".$longitude."' WHERE user = '".$username."' ");
    
    if($stmt){
        $chk = "DATA INSERTED";
        
     
        
    }else{
        $chk = "INSERTION FAILED";
    }
    


    // Generate token and return it to client
    $token = bin2hex(openssl_random_pseudo_bytes(16));
    echo json_encode(array("token" => $token, "status" => $status, "lat"=>$latitude, "lng"=>$longitude, "instatus"=>$chk));
    
    
    // Generate JavaScript code to save the variables in sessionStorage
    echo "<script>";
    echo "sessionStorage.setItem('user', '" . $username . "');";
    echo "sessionStorage.setItem('token', '" . $token . "');";
    echo "window.location.href = 'https://health.aiiot.website/dashboard/patient/index.html';"; // Replace 'dashboard.php' with the actual dashboard URL
    echo "</script>";       
    
} else {
    // Return error message to client
    echo json_encode(array("error" => "Invalid username or password"));
}

mysqli_close($conn);

?>




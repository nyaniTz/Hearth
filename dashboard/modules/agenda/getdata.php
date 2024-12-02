<?php
session_start();
// include('../../../includes/conn.php');
// Connect to the database
$dbHost = "localhost";
$dbUser = "aiiovdft_health";
$dbPass = "Marvelyiky";
$dbName = "aiiovdft_health";

try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

// Check if the 'action' parameter is set and fetch the data accordingly

function fetch_services() {
    $db = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');
    $query = "SELECT service_name FROM services";
    $result = $db->query($query);

    $output = '<option value="">-- Select a Service --</option>';
    while ($row = $result->fetch_assoc()) {
        $output .= '<option value="' . $row['specialty'] . '">' . $row['name'] . '</option>';
    }

    return $output;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Fetch services
    if ($action == 'fetch_services') {

        $db = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');

        // Check for connection errors
        if($db->connect_errno) {
            die("Connection failed: " . $db->connect_error);
        };
        
        // Fetch services from the database
        $query = "SELECT specialty, name FROM services";
        $result = $db->query($query);

        $services = '<option value="">-- Select a Service --</option>';

        // Loop through all rows in the result set and add to services variable
        while($row = $result->fetch_assoc()) {
            $services .= '<option value="' . $row['specialty'] . '">' . $row['name'] . '</option>';
        }
    
        // Close the result set and database connection
        $result->close();
        $db->close();
    
        // Return services as response to ajax call
        echo $services;
    }

    // Fetch doctors for a particular service
    if ($action == 'fetch_doctors') {
        $service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT);
    
        $db = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');
    
        // Check for connection errors
        if ($db->connect_errno) {
            die("Connection failed: " . $db->connect_error);
        }
            
        // Fetch doctors from the database
        $query = "SELECT firstname, lastname FROM doctors WHERE specialty = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $doctors = '<option value="">-- Select a Doctor --</option>';
    
        // Loop through all rows in the result set and add to doctors variable
        while ($row = $result->fetch_assoc()) {
            $doctors .= '<option value="' . $row['firstname'] . ' ' . $row['lastname'] . '">' . $row['firstname'] . ' '. $row['lastname'] . '</option>';
        }
        
        // Close the result set, statement, and database connection
        $result->close();
        $stmt->close();
        $db->close();
        
        // Return doctors as response to ajax call
        echo $doctors;
    }

    if($action == 'check_schedule_conflict'){
        // Get the chosen appointment date and time and doctor's ID from the AJAX request


        $doctor_id = $_POST['doctor_id'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        
        $db = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');
        
        // Check for connection errors
        if($db->connect_errno) {
            die("Connection failed: " . $db->connect_error);
        }
        
        // Check if slot is available
        $query = "SELECT * FROM schedules WHERE user = '".$doctor_id."' AND date = '".$date."' AND end_time > '".$time."' AND start_time < '".$time."'";
        $result = $db->query($query);
        
        if ($result->num_rows > 0) {
            echo 'unavailable';
        } else {
            echo 'available';
        }
        
        // Close the result set and database connection
        $result->close();
        $db->close();

    }

    if ($action == 'get_appointments') {
        // Get the chosen appointment date and time and doctor's ID from the AJAX request
        $user = $_SESSION['user_id'];
        
        $db = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');
        
        // Check for connection errors
        if ($db->connect_errno) {
            die("Connection failed: " . $db->connect_error);
        }
        
        // Check if slot is available
        $query = "SELECT * FROM appointments WHERE patient_id = '$user'";
        $result = $db->query($query);
        
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo 'No Data Found';
        }
        
        // Close the result set and database connection
        $result->close();
        $db->close();
    }
    


    if ($action == 'save_appointment') {
        // Get the values from the Ajax request
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $endtime = $_POST['endtime'];
        $payment_method = $_POST['payment_method'];
        $status = $_POST['status'];
        $service = $_POST['service'];
        $doctor = $_POST['doctor'];
    
        // Connect to the database
        $conn = new mysqli('localhost', 'aiiovdft_health', 'Marvelyiky', 'aiiovdft_health');
    
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        // Prepare the SQL query to insert the data into the appointments table
        $query = "INSERT INTO appointments (patient_id, patient_email, patient_phone, doctor_id, appointment_date, appointment_time, service_type, service_description, appointment_status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssss", $name, $email, $phone, $doctor, $date, $time, $service, $description, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        // Prepare the SQL query to insert the data into the schedules table
        $query = "INSERT INTO schedules (date, user, start_time, end_time, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $date, $doctor, $time, $endtime, $service);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['user_id'] = $name;
        // Close the database connection
        mysqli_close($conn);
    }
    


}



?>

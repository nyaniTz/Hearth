<?php

include('../includes/conn.php');


function update_hbr($db, $username, $hbr, $lat, $lng) {
  // Update the HBR value for the given user
  if(isset($lat)) {
    $sql = "UPDATE patients SET SBP = '".$hbr."', latitude='".$lat."', longitude='".$lng."' WHERE user = '".$username."'";
    $msg = "Heartbeat Rate, Latitude and Longitude Updated Successfully for user: $username";
  } else {
    $sql = "UPDATE patients SET SBP = '".$hbr."' WHERE user = '".$username."'";
    $msg = "HBR value updated for user:  $username";
  }


  if ($db->query($sql) === TRUE) {
    // Return a success message
    return $msg;
  } else {
    // Return an error message
    return "Error updating HBR value: " . $db->error;
  }

  // Close the database connection
  $db->close();
}





//CRUD SECTION
// Database connection details
$host = "localhost";
$username = "aiiovdft_health";
$password = "Marvelyiky";
$dbname = "aiiovdft_health";
// Establish database connection
$connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Function to create a new patient
function createPatient($data) {
    global $connection;
    
    $sql = "INSERT INTO patients (Name, Address, Age, Ambulation, BMI, Chills, Contacts, DOB, Email, DBP, DecreasedMood, FiO2, GeneralizedFatigue, HeartRate, HistoryFever, RR, RecentHospitalStay, SBP, SpO2, Temp, WeightGain, WeightLoss, BGroup, Sex, pass, latitude, longitude, status, user)
            VALUES (:Name, :Address, :Age, :Ambulation, :BMI, :Chills, :Contacts, :DOB, :Email, :DBP, :DecreasedMood, :FiO2, :GeneralizedFatigue, :HeartRate, :HistoryFever, :RR, :RecentHospitalStay, :SBP, :SpO2, :Temp, :WeightGain, :WeightLoss, :BGroup, :Sex, :pass, :latitude, :longitude, :status, :user)";
    
    $statement = $connection->prepare($sql);
    $statement->execute($data);
    
    return $connection->lastInsertId();
}

// Function to read patient details
function getPatient($user) {
    global $conn;
    
    $sql = "SELECT * FROM patients WHERE user = '$user'";
    
    $result = mysqli_query($conn, $sql);
    $rows = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows;
}

if (isset($_GET['user']) && count($_GET) === 1) {
    $user = $_GET['user'];
    $result = getPatient($user);

    header('Content-Type: application/json'); // Set the response content type as JSON
    echo json_encode($result);
}
    


// Function to update patient details
// function updatePatient($user, $field_list, $value_list) {
//     global $conn;

//     // Build the SET clause dynamically
//     $set_clause = '';
//     $num_fields = count($field_list);

//     for ($i = 0; $i < $num_fields; $i++) {
//         $set_clause .= $field_list[$i] . ' = ?';

//         if ($i < $num_fields - 1) {
//             $set_clause .= ', ';
//         }
//     }

//     $sql = "UPDATE patients SET $set_clause WHERE user = ?";

//     $statement = $conn->prepare($sql);

//     // Bind the field values
//     $value_types = str_repeat('s', $num_fields) . 's';
//     $bind_params = array_merge($value_list, [$user]);
//     $statement->bind_param($value_types, ...$bind_params);

//     $statement->execute();

//     return $statement->affected_rows;
// }



function updatePatient($user, $field_list, $value_list) {
    global $conn;

    // Build the SET clause dynamically
    $set_clause = '';
    $num_fields = count($field_list);
    $has_temp = in_array("Temp", $field_list);

    for ($i = 0; $i < $num_fields; $i++) {
        $set_clause .= $field_list[$i] . ' = ?';

        if ($i < $num_fields - 1) {
            $set_clause .= ', ';
        }
    }

    $sql = "UPDATE patients SET $set_clause WHERE user = ?";
    
    if ($has_temp) {
        // Get the value of "Temp" from $value_list
        $temp_index = array_search("Temp", $field_list);
        $temp_value = $value_list[$temp_index];
        
        // Make the POST request
        $url = "https://health.masatafit.com/api/user/vital/$user?type=temperature&temperature=$temp_value";
        $options = array(
            'http' => array(
                'method' => 'POST',
            )
        );
        $context = stream_context_create($options);
        file_get_contents($url, false, $context);
    }

    $statement = $conn->prepare($sql);

    // Bind the field values
    $value_types = str_repeat('s', $num_fields) . 's';
    $bind_params = array_merge($value_list, [$user]);
    $statement->bind_param($value_types, ...$bind_params);

    $statement->execute();

    return $statement->affected_rows;
}




if (isset($_GET['user']) && count($_GET) > 1) {
    // Capture the value of $user from the GET request
    $user = $_GET['user'];
    $dId = $_GET['dId'];

    // Remove the 'user' key from the $_GET array
    unset($_GET['user']);
    unset($_GET['dId']);

    // Capture the remaining field-value pairs
    $field_list = array_keys($_GET);
    $value_list = array_values($_GET);
    $ecg_value = $value_list[array_search('ecg', $field_list)];
    $ecgArray = explode(",", $_GET['ecg']);

    // Call the updatePatient function
    $result = array("status"=>"OK","ecg"=>$ecgArray);//updatePatient($user, $field_list, $value_list);

    // Echo a message based on the result
    if ($result) {
        echo json_encode($result);
    } else {
        echo "Failed to receive ecg.";
    }
}





// Function to delete a patient
function deletePatient($user) {
    global $connection;
$sql = "DELETE FROM patients WHERE user = :user";

$statement = $connection->prepare($sql);
$statement->bindParam('user', $user, PDO::PARAM_INT);
$statement->execute();

return $statement->rowCount();
}

// // Example usage:

// // Create a new patient
// $data = [
//     'Name' => 'John Doe',
//     'Address' => '123 Main St',
//     'Age' => 30,
//     'Ambulation' => 1,
//     'BMI' => 24.5,
//     'Chills' => 0,
//     // Add values for other columns
//     'user' => 'john_doe'
// ];

// $newPatientId = createPatient($data);
// echo "New patient ID: $newPatientId\n";

// // Retrieve patient details
// $patientId = 1; // Example patient ID
// $patientDetails = getPatient($patientId);
// print_r($patientDetails);

// // Update patient details
// $patientId = 1; // Example patient ID
// $dataToUpdate = [
//     'Name' => 'Jane Smith',
//     'Address' => '456 Elm St',
//     'Age' => 35,
//     'Ambulation' => 0,
//     // Add values for other columns
//     'user' => 'jane_smith'
// ];

// $updatedRows = updatePatient($patientId, $dataToUpdate);
// echo "Updated rows: $updatedRows\n";

// // Delete a patient
// $patientId = 1; // Example patient ID
// $deletedRows = deletePatient($patientId);
// echo "Deleted rows: $deletedRows\n";
    

function getUserData($searchName, $conn){
    
    $query = "SELECT * FROM patients WHERE user = '$searchName'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {

        $response = array('message' => 'No User in database with that UserName. Try to another name.');
    } else {
        $query = "SELECT * FROM patients WHERE user = '$searchName'";
        $result = mysqli_query($conn, $query);
        $patient = mysqli_fetch_assoc($result);

        $response = array('patient' => array($patient));
    }

    // Set the response header to JSON and echo the response
    header('Content-Type: application/json');
    echo json_encode($response);

}

    
    
// Check if the AJAX request was made with the necessary parameters
if (isset($_GET['user']) && isset($_GET['hbr'])) {
  $username = $_GET['user'];
  $hbr = $_GET['hbr'];
  $lat = $_GET['lat'];
  $lng = $_GET['lng'];
  $result = update_hbr($conn, $username, $hbr, $lat, $lng);
  echo $result;
}

if (isset($_GET['user']) ) {
  $user = $_GET['user'];
  $result = getPatient($user);
  echo $result;
}    
    
if (isset($_GET['oneUser']) ) {
  $searchName = $_GET['oneUser'];
  getUserData($searchName,$conn);
  
}     
    
    

?>

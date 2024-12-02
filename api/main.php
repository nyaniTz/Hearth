<?php
include('../includes/conn.php');



// Handle the API actions
if (isset($_POST['action'])) {
  $action = $_POST['action'];

  // Perform the action based on the request
  switch ($action) {
    case 'fetch_appointments':
      fetchAppointments($conn);
      break;
    case 'delete_appointment':
      if (isset($_POST['appointment_id'])) {
        $appointmentId = $_POST['appointment_id'];
        deleteAppointment($conn, $appointmentId);
      }
      break;
    case 'fetch_ecg':
      if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        fetchECG($conn, $userId);
      }
      break;
    // Add more cases for other actions if needed
    default:
      // Invalid action
      $response = array('success' => false, 'message' => 'Invalid action');
      echo json_encode($response);
      break;
  }
}







function fetchAppointments($conn) {
  // Fetch appointments from the database
  $query = "SELECT * FROM appointments";
  $result = mysqli_query($conn, $query);

  
  if ($result) {
      $appointments = mysqli_fetch_assoc($result); 
      
      
      
      // Return the appointments as JSON response
      
      $response = array('success' => true, 'appointments' => $appointments);
      header('Content-Type: application/json');
      echo json_encode($response);
  } else {
    // Error in fetching appointments
    $response = array('success' => false, 'message' => 'Error fetching appointments');
    echo json_encode($response);
  }
}


function fetchECG($conn, $userId) {
  // Fetch appointments from the database
  $query = "SELECT * FROM patients where user = '$userId'";
  $result = mysqli_query($conn, $query);

  
  if ($result) {
      $vitals = mysqli_fetch_assoc($result); 
      
      
      
      // Return the appointments as JSON response
      
      $response = array('success' => true, 'ecg' => $vitals['ecg']);
      header('Content-Type: application/json');
      echo json_encode($response);
  } else {
    // Error in fetching appointments
    $response = array('success' => false, 'message' => 'Error fetching ecg');
    echo json_encode($response);
  }
}

function deleteAppointment($conn, $appointmentId) {
  // Sanitize the appointment ID
  $appointmentId = mysqli_real_escape_string($conn, $appointmentId);

  // Delete the appointment from the database
  $query = "DELETE FROM appointments WHERE appointment_id = '$appointmentId'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Appointment deleted successfully
    $response = array('success' => true, 'message' => 'Appointment deleted successfully');
    echo json_encode($response);
  } else {
    // Error in deleting the appointment
    $response = array('success' => false, 'message' => 'Error deleting appointment');
    echo json_encode($response);
  }
}


// Check if the request method is POST
if (isset($_POST['table'])&&isset($_POST['fields'])) {
    // Retrieve the table name and fields from the POST data
    $table = $_POST['table'];
    $fields = $_POST['fields'];

    // Call the updateTable function
    $result = updateTable($conn, $table, $fields);

    // Prepare the response
    $response = array();

    if ($result) {
        // Update successful
        $response['success'] = true;
        $response['message'] = "Update successful!";
    } else {
        // Update failed
        $response['success'] = false;
        $response['message'] = "Update failed!";
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function updateTable($conn, $table, $fields) {
    // Build the SET clause for the update query
    $setClause = '';
    foreach ($fields as $fieldName => $fieldValue) {
        $fieldValue = mysqli_real_escape_string($conn, $fieldValue); // Sanitize the field value
        $setClause .= "$fieldName = '$fieldValue', ";
    }
    $setClause = rtrim($setClause, ', '); // Remove the trailing comma and space

    // Build and execute the update query
    $query = "UPDATE $table SET $setClause";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Update successful
        return true;
    } else {
        // Update failed
        return false;
    }
}


function fetchCoordinates($user, $conn) {
    $query = "SELECT coordinates FROM location WHERE user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    $coordinates = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $coordinates = json_decode($row['coordinates'], true);
        }
    }

    return $coordinates;
}

if (count($_GET) === 1 && isset($_GET['theUser'])) {
    $user = $_GET['theUser'];

    // Call the fetchCoordinates function and store the result
    $userCoordinates = fetchCoordinates($user, $conn);

    // Output the result as JSON
    $response = array('success' => true, 'message' => 'Coordinates Fetched successfully', 'coordinates'=> $userCoordinates);
    
    
    header('Content-Type: application/json');
    echo json_encode($response);
}


// SAVE COORDINATES
function saveCoordinates($user, $latLng, $conn) {
  // Check if the user already exists in the locations table
  $query = "SELECT COUNT(*) AS count FROM location WHERE user = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $user);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $count = $row['count'];

  $coordinates = array();
  if ($count > 0) {
    // User exists, retrieve existing coordinates
    $query = "SELECT coordinates FROM location WHERE user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $coordinates = json_decode($row['coordinates'], true);
  }

  if ($count > 0 && count($coordinates) >= 30) {
    // If the array is at maximum length, remove the oldest element
    array_shift($coordinates);
  }

  // Add the incoming coordinates to the array
  $coordinates[] = array('latitude' => $latLng['latitude'], 'longitude' => $latLng['longitude']);

  if ($count > 0) {
    // User exists, update the coordinates array in the database
    $updateQuery = "UPDATE location SET coordinates = ? WHERE user = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('ss', json_encode($coordinates), $user);
    $updateStmt->execute();
    
    
    $updateQuery2 = "UPDATE patients SET latitude = ?, longitude=? WHERE user = ?";
    $updateStmt2 = $conn->prepare($updateQuery2);
    $updateStmt2->bind_param('sss', $latLng['latitude'],$latLng['longitude'], $user);
    $updateStmt2->execute();
    
  } else {
    // User does not exist, insert the coordinates array into the database
    $insertQuery = "INSERT INTO location (user, coordinates) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param('ss', $user, json_encode($coordinates));
    $insertStmt->execute();
  }

  // Return a success message
  return "Coordinates saved successfully!";
}

if (isset($_POST['target']) && isset($_POST['coordinates'])) {
  $user = $_POST['target'];
  $latLng = json_decode($_POST['coordinates'], true);

  // Call the saveCoordinates function and store the result
  $res = saveCoordinates($user, $latLng, $conn);

  // Output the result as JSON
  header('Content-Type: application/json');
  echo json_encode($res);
}


// // RECEIVE COORDINATES FROM MOBILE
// if (isset($_POST['theUser']) && isset($_POST['payload'])) {
//   $user = $_POST['theUser'];
//   $latLng = json_decode($_POST['payload'], true);

//   // Call the saveCoordinates function and store the result
//   $res = saveCoordinates($user, $latLng, $conn);

//   // Output the result as JSON
//   header('Content-Type: application/json');
//   echo json_encode($res);
// }

// $user = "jsmith";
// $latLng = array(
//     'latitude' => 33.23252,
//     'longitude' => 35.21545
// );
// $result = saveCoordinates($user, $latLng, $conn);

// Output the result

if (isset($_GET['theUser']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    // Retrieve the values from the GET parameters
    $theUser = $_GET['theUser'];
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];

    $latLng = array(
        'latitude' => $latitude,
        'longitude' => $longitude
    );
    // Call the saveCoordinates function with the provided data
    $res = saveCoordinates($theUser, $latLng, $conn);
    // Output the result as JSON
    header('Content-Type: application/json');
    echo json_encode($res);
    
}



//MAIL SENDING REQUISITES
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($receiverAddress, $receiverName, $message) {
	$mail = new PHPMailer(true);

	try {
		$mail->SMTPDebug = 2;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'vmercel@gmail.com';
		$mail->Password = 'osstpclnywlayvxn';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;

		$mail->setFrom('vmercel@gmail.com', 'AIIoT Research Centre');
		$mail->addAddress($receiverAddress, $receiverName);

		$mail->isHTML(true);
		$mail->Subject = 'AIIoT Health Services';
		$mail->Body = $message;
		$mail->AltBody = 'Body in plain text for non-HTML mail clients';
		$mail->send();
		echo "Mail has been sent successfully!";
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}


//SEND EMAIL TO NOTIFY APPOINTMENT IS BOOKING IS RECEIVED
function book_appointment($receiverAddress, $receiverName, $appdate){
$startDate = date('Ymd\THis\Z', strtotime('today'));
$endDate = date('Ymd\THis\Z', strtotime($appdate));
$date = $startDate . '/' . $endDate;


$message = "<html>
<head>
<style>
  body {
    font-family: Arial, sans-serif;
    line-height: 1.5;
  }
  
  h1 {
    font-size: 24px;
    color: #333333;
    margin-bottom: 20px;
  }
  
  .button-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #ffffff;
    text-decoration: none;
    border-radius: 4px;
  }
  
  .button-link:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  
  <p>
    Dear <h2>$receiverName,</h2>
    <br><br>
    

    Your appointment with <h4>AIIoT Health Services</h4> on <h4>$appdate</h4> has been received.
    <br><br>
  
    You will be notified once the doctor confirms your appointment
    <br><br>
   
  </p>
  <p>
    See you soon,
    <br><br>
    AIIoT Secretariat
  </p>
</body>
</html>";


sendEmail($receiverAddress, $receiverName, $message);

}




// SEND EMAIL TO CONFIRM APPOINTMENT
function confirm_appointment($receiverAddress, $receiverName, $appdate){
$startDate = date('Ymd\THis\Z', strtotime('today'));
$endDate = date('Ymd\THis\Z', strtotime($appdate));
$date = $startDate . '/' . $endDate;


$message = "<html>
<head>
<style>
  body {
    font-family: Arial, sans-serif;
    line-height: 1.5;
  }
  
  h1 {
    font-size: 24px;
    color: #333333;
    margin-bottom: 20px;
  }
  
  .button-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #ffffff;
    text-decoration: none;
    border-radius: 4px;
  }
  
  .button-link:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  
  <p>
    Dear <h2>$receiverName,</h2>
    <br><br>
    I hope this message finds you well.
    <br>
    Your appointment with <h4>AIIoT Health Services</h4> on <h4>$appdate</h4> has been confirmed.
    <br>
  
    Please click the button below to add the appointment to your Google Calendar:
    <br><br>
    <a class='button-link' href='https://www.google.com/calendar/render?action=TEMPLATE&text=Health Service Appointment&dates=$date'>Add to Google Calendar</a>
  </p>
  <p>
    See you soon,
    <br><br>
    AIIoT Secretariat
  </p>
</body>
</html>";


sendEmail($receiverAddress, $receiverName, $message);

}



// Example usage:
// $receiverAddress = 'vmercel@gmail.com';
// $receiverName = 'Mercel Vubangsi';
// $appdate = '10-06-2023 11:30';

// confirm_appointment($receiverAddress, $receiverName, $appdate);





// Check if the required POST data is set
if (isset($_GET['appointdate']) && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['doctor'])) {
  // Retrieve the GET data
  $date = $_GET['appointdate'] . " " . $_GET['time'];
  $name = $_GET['name'];
  $email = $_GET['email'];
  $doctor = $_GET['doctor'];

  // Fetch doctor details from the database
  $query = "SELECT * FROM doctors WHERE CONCAT(firstname, ' ', lastname) = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $doctor);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if a doctor was found
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctorEmail = $row['email'];
    
    $doctorMessage = "<html>
<head>
<style>
  body {
    font-family: Arial, sans-serif;
    line-height: 1.5;
  }
  
  h1 {
    font-size: 24px;
    color: #333333;
    margin-bottom: 20px;
  }
  
  .button-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #ffffff;
    text-decoration: none;
    border-radius: 4px;
  }
  
  .button-link:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  
  <p>
    Dear <h2>Dr. $doctor,</h2>
    <br><br>
    <br>
    A user has booked your service through the <h4>AIIoT Health Services</h4> online platform for <h4>$date</h4> .
    <br>
  
    Please Login to your account to confirm.
    <br><br>

  </p>
  <p>
    Best Regards,
    <br><br>
    AIIoT Secretariat
  </p>
</body>
</html>";
    // Call the send_email_notification function with the data
    sendEmail($doctorEmail, $doctor, $doctorMessage);
    book_appointment($email, $name, $date);

    // Send a success response
    $response = array('success' => true, 'message' => 'Email notification sent successfully');
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    // Send an error response if doctor not found
    $response = array('success' => false, 'message' => 'Doctor not found');
    header('Content-Type: application/json');
    echo json_encode($response);
  }
} 



// CONFIRMATION MESSAGE WHEN DOCTOR CONFIRMS APPOINTMENT

if (isset($_GET['appointID']) && isset($_GET['appointDateTime'])) {
    // Retrieve the GET data
    global $conn;
    $appointmentID = $_GET['appointID'];
    $appointmentDateTime = $_GET['appointDateTime'];
    
    // Fetch patient_name and patient_email from appointments table
    // Assuming you have a database connection established
    
    // Make sure to properly sanitize and validate the input before using in a query
    $appointmentID = $_GET['appointID'];
    
    // Construct the query
    $query = "SELECT * FROM appointments WHERE appointment_id = '$appointmentID'";
    
    // Execute the query
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the patient_name and patient_email
            $row = mysqli_fetch_assoc($result);
            $patientName = $row['patient_id'];
            $patientEmail = $row['patient_email'];
            
            // Call the confirm_appointment function with the retrieved data
            confirm_appointment($patientEmail, $patientName, $appointmentDateTime);
            
            // Send a success response
            $response = array('success' => true, 'message' => 'Appointment confirmed successfully');
            echo json_encode($response);
        } else {
            // Patient not found
            $response = array('success' => false, 'message' => 'Patient not found');
            echo json_encode($response);
        }
    } else {
        // Error in the database query
        $response = array('success' => false, 'message' => 'Error executing database query');
        echo json_encode($response);
    }
}


?>

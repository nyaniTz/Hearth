<?php

// Connect to MySQL database
include("../../includes/conn.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for MQTT server details
$mqttserver = "";
$mqttuser = "";
$mqttpass = "";

// Get user and token values from the request
$user = $_GET['user'];
$token = $_GET['token'];

// Validate the user and token values
if (validateUserAndToken($user, $token)) {
    // If valid, get the MQTT server details from the database
    $sql = "SELECT mqttserver, mqttuser, mqttpass FROM devices WHERE user = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Store the MQTT server details in the variables
        while($row = $result->fetch_assoc()) {
            $mqttserver = $row["mqttserver"];
            $mqttuser = $row["mqttuser"];
            $mqttpass = $row["mqttpass"];
        }
    }
}

// Return the MQTT server details in JSON format
echo json_encode(array("mqttserver" => $mqttserver, "mqttUser" => $mqttuser, "mqttPass" => $mqttpass));

// Close the MySQL connection
$conn->close();

// Validate the user and token values
function validateUserAndToken($user, $token) {
    // Add your own code here to check if the user and token values are valid
    // You can use a database or other methods to validate the user and token
    return true;
}

?>

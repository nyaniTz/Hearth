<?php
// Establish MySQL connection
include('../includes/conn.php');

$db = $conn;

// Function to save GPS coordinates to the database
function saveCoordinates($latitude, $longitude)
{
    global $db;

    // Fetch current coordinates from the database
    $result = $db->query("SELECT latitude, longitude FROM patients WHERE user='jsmith'");
    $row = $result->fetch_assoc();
    $latitudeArray = $row ? json_decode($row['latitude'], true) : [];
    $longitudeArray = $row ? json_decode($row['longitude'], true) : [];

    // Update the coordinates arrays
    if (count($latitudeArray) == 20) {
        array_shift($latitudeArray); // Remove the oldest coordinate if the array is full
        array_shift($longitudeArray);
    }
    $latitudeArray[] = $latitude;
    $longitudeArray[] = $longitude;

    // Save the updated coordinates to the database
    $latitudeJson = json_encode($latitudeArray);
    $longitudeJson = json_encode($longitudeArray);

    if ($row) {
        $db->query("UPDATE patients SET latitude='$latitudeJson', longitude='$longitudeJson' WHERE user='jsmith'");
    } else {
        $db->query("INSERT INTO patients (latitude, longitude) VALUES ('$latitudeJson', '$longitudeJson') WHERE user = 'jsmith'");
    }
    echo "PROCESS COMPLETED";
}

// Example usage
$latitude = '12.3456';
$longitude = '-78.9012';
saveCoordinates($latitude, $longitude);

// Close the database connection
$db->close();
?>

<?php
// Connect to the database
$dbHost = "localhost";
$dbUser = "aiiovdft_health";
$dbPass = "Marvelyiky";
$dbName = "aiiovdft_health";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch patient data for user "jsmith"
    $user = $_GET['user'];
    $query = "SELECT HeartRate, Temp, DBP, SpO2, Age, BMI FROM patients WHERE user = :user";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user', $user);
    $statement->execute();

    // Fetch the patient data as an associative array
    $patientData = $statement->fetch(PDO::FETCH_ASSOC);

    // Return the patient data as JSON
    header('Content-Type: application/json');
    echo json_encode($patientData);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

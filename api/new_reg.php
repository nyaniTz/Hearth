<?php
// Check if the request method is GET
function calculateAge($dob) {
    $currentDate = new DateTime();
    $birthDate = DateTime::createFromFormat('Y-m-d', $dob);
    $ageInterval = $currentDate->diff($birthDate);
    return $ageInterval->y;
}


function rndNum($min, $max) {
    return rand($min * 10, $max * 10) / 10;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the values from the GET request
    $name = $_GET['name'];
    $address = $_GET['adress'];
    $age = calculateAge($_GET['birth']); // Assuming you have a function to calculate age
    $contacts = $_GET['phone'];
    $email = $_GET['email'];
    $bGroup = $_GET['blood'];
    $sex = $_GET['sex'];
    $pass = $_GET['pass1'];
    $user = $_GET['user'];
    $dob = $_GET['birth'];

    // Create the data template to be sent to signup.php
    $formData = [
        "newpatient" => [
            "Name" => $name,
            "Address" => $address,
            "Age" => $age,
            "Ambulation" => false,
            "BMI" => rndNum(18.5, 24.9), // Assuming you have a function to generate a random number
            "Chills" => false,
            "Contacts" => $contacts,
            "DOB" => $dob,
            "Email" => $email,
            "DBP" => rndNum(60, 80),
            "DecreasedMood" => false,
            "FiO2" => rndNum(50, 100),
            "GeneralizedFatigue" => false,
            "HeartRate" => rndNum(60, 100),
            "HistoryFever" => "Never",
            "RR" => rndNum(12, 16),
            "RecentHospitalStay" => "00/00/0000",
            "SBP" => rndNum(90, 120),
            "SpO2" => rndNum(90, 100),
            "Temp" => rndNum(95, 99),
            "WeightGain" => 0,
            "WeightLoss" => 0,
            "BGroup" => $bGroup,
            "Sex" => $sex,
            "pass" => $pass,
            "user" => $user
        ]
    ];

    // Convert the data to JSON format
    $jsonData = json_encode($formData);

    // Send the data to signup.php using an AJAX call
    $url = 'https://health.aiiot.website/signup/signup.php'; // Replace with the actual URL
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => $jsonData
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    // Process the response from signup.php
    // ... (handle the response as per your requirements)
    echo "USER CREATED SUCCESSFULLY DONE  <br>";
    echo $jsonData;
}




<?php


if(isset($_POST['send_message'])){
    // Get the message from the form input
    $message = $_POST['chat_message'];

    // Perform any necessary validation or sanitization of the message


    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert the message
    $sql = "INSERT INTO messages (patient_id, patient_name, Message, reply) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $patientId = 1; // Assuming you have a patient ID
    $patientName = "John Doe"; // Assuming you have a patient name
    $reply = ""; // Assuming there's no reply initially

    $stmt->bind_param("iss", $patientId, $patientName, $message, $reply);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Message inserted successfully!";
    } else {
        echo "Error inserting message: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

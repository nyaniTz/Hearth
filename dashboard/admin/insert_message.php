<?php
// Assuming you have a database connection established
include 'conn.php';
if (isset($_POST['send_message'])) {

    $message = isset($_POST['chat_message']) ? $_POST['chat_message'] : '';

    echo 'Debug - $message: ' . $message . '<br>'; // Debug statement
    
    if (!empty($message)) {
        // Perform the database insertion
        $query = "INSERT INTO messages (patient_id, patient_name, Message) VALUES (1, 'John Doe', '$message')";
  
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die('Database insertion error: ' . mysqli_error($conn));
        }

        echo 'Message inserted successfully.';
    } else {
        echo 'Message is empty. Please enter a message.';
    }
}
?>

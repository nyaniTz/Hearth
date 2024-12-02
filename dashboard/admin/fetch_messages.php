<?php
// Code to fetch messages from the database and generate HTML

// Assuming you have a database connection established
// Replace DB_HOST, DB_USERNAME, DB_PASSWORD, and DB_NAME with your actual database credentials
include 'conn.php';



// Assuming you have a table named 'messages' with columns 'id' and 'message'
$sql = "SELECT * FROM messages";
$result = $conn->query($sql);

$html = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $message = $row['Message'];
        // You can format the message HTML according to your preference
        $html .= '<div class="imessage">' . '<p class="from-them">' . $message . '</p>' . '</div>';

    }
} else {
    $html = 'No messages found.';
}

$conn->close();

// Return the generated HTML
echo $html;
?>

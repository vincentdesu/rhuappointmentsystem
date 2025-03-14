<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "appointmentsystem";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update status where schedule_date is past
$sql = "UPDATE appointments SET status = 'Cancelled' WHERE schedule_date < NOW() AND status = 'Pending'";

if ($conn->query($sql) === TRUE) {
    echo "✅ Status updated successfully!";
} else {
    echo "❌ Error updating status: " . $conn->error;
}

$conn->close();
?>

<?php
 // Include database connection
$pdo = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$service = $_GET['service'] ?? '';
$date = $_GET['date'] ?? '';
$time = $_GET['time'] ?? '';

if ($service && $date && $time) {
    $stmt = $pdo->prepare("SELECT (max_slots - booked_count) AS available FROM slots WHERE service = ? AND schedule_date = ? AND time_slot = ?");
    $stmt->execute([$service, $date, $time]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode(["slotCount" => max(0, $result['available'])]); // Prevent negative slots
    } else {
        echo json_encode(["slotCount" => 0]);
    }
} else {
    echo json_encode(["slotCount" => "Invalid input"]);
}

header('Content-Type: application/json');
?>

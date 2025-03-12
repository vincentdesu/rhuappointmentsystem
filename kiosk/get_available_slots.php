<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if (isset($_GET['service'], $_GET['date'], $_GET['time'])) {
    $selectedService = $_GET['service'];
    $selectedDate = $_GET['date'];
    $selectedTime = $_GET['time'];
    
    // Query to get the available slots based on service, date, and time
    $stmt = $pdo->prepare("SELECT booked_count, total_slots FROM slots WHERE service = :service AND schedule_date = :date AND time_slot = :time");
    $stmt->execute(['service' => $selectedService, 'date' => $selectedDate, 'time' => $selectedTime]);

    // Fetch the result
    $slotData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($slotData) {
        // Calculate the available slots
        $availableSlots = $slotData['total_slots'] - $slotData['booked_count'];

        // Return the number of available slots
        echo json_encode(['slotCount' => $availableSlots]);
    } else {
        // If no slots are found, return 0 available slots
        echo json_encode(['slotCount' => 0]);
    }
}
?>

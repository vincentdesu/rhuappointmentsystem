<?php
require('fpdf.php'); // Load FPDF library

// Connect to your database
$host = "localhost";
$username = "root";
$password = "";
$database = "appointmentsystem"; // Change this to your database name

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch appointment data from database
$query = "SELECT fullname, schedule_date, time_slot, service, reason FROM appointments WHERE status = 'Completed'";
$stmt = $conn->prepare($query);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Appointments Report', 1, 1, 'C');
$pdf->Ln(10);

// Table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Name', 1);
$pdf->Cell(30, 10, 'Date', 1);
$pdf->Cell(20, 10, 'Time', 1);
$pdf->Cell(40, 10, 'Service', 1);
$pdf->Cell(50, 10, 'Reason', 1);
$pdf->Ln();

// Table data
$pdf->SetFont('Arial', '', 12);
foreach ($appointments as $row) {
    $pdf->Cell(50, 10, $row['fullname'], 1);
    $pdf->Cell(30, 10, $row['schedule_date'], 1);
    $pdf->Cell(20, 10, $row['time_slot'], 1);
    $pdf->Cell(40, 10, $row['service'], 1);
    $pdf->Cell(50, 10, $row['reason'], 1);
    $pdf->Ln();
}

// Output PDF as a download
$pdf->Output('D', 'Appointments_Report.pdf');
exit();
?>

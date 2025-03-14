<?php
require_once('admin_functions.php');
if (isset($_GET['submit'])) {
    $services = $admin_functions->show_appoints_completed_filtered();
} else {
    $services = $admin_functions->show_appoints_completed();
}



// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Number of records per page
$itemsPerPage = 10;

// Get the current page from URL, default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Fetch total number of records
$stmt = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'Completed'");
$totalRows = $stmt->fetchColumn();
$totalPages = ceil($totalRows / $itemsPerPage);

// Fetch paginated data
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE status = 'Completed' ORDER BY schedule_date DESC LIMIT :offset, :items");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':items', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$services['appointments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $connection = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");

// $query = $connection->query("SELECT service, COUNT(*) as total FROM appointments WHERE status = 'Completed' GROUP BY service");
// $data = $query->fetchAll(PDO::FETCH_ASSOC);

// $chart_services = [];
// $counts = [];
// foreach ($data as $row) {
//     $chart_services[] = $row['service'];
//     $counts[] = $row['total'];
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-success px-3">
        <a class="navbar-brand" href="#"><img src="logo.png" alt="Logo" width="30"> Rural Health Unit I</a>
        <button class="btn btn-primary">Logout</button>
    </nav>
    
    <div class="d-flex">
    <nav class="bg-dark text-white p-3 min-vh-100 d-flex flex-column" style="width: 250px;">

            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white active bg-primary">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
            </ul>
        </nav>
        
        <div class="container my-4">
            <h2>Report</h2>
            <form class="row g-3" method = "GET">
                <div class="col-md-4">
                    <label class="form-label">Choose a service:</label>
                    <select class="form-select" name="service">
                        <option value="">All</option>
                        <option value="checkup">Check Up</option>
                        <option value="dentalcares">Dental Cares</option>
                        <option value="animalbites">Animal Bites</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Start Date:</label>
                    <input type="date" class="form-control" name="start-date" >
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date:</label>
                    <input type="date" class="form-control" name="end-date" >
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success" name = "submit">Filter</button>
                </div>
            </form>
            
            <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4"> <!-- Adjust column size -->
            <canvas id="reportChart" class="my-4 w-100"></canvas>
        </div>
    </div>
</div>
            
            <table class="table table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Name</th>
                        <th>Schedule Date</th>
                        <th>Time</th>
                        <th>Service</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services['appointments'] as $service) { ?>
                        <tr>
                            <td><?= htmlspecialchars($service['fullname']) ?></td>
                            <td><?= htmlspecialchars($service['schedule_date']) ?></td>
                            <td><?= htmlspecialchars($service['time_slot']) ?></td>
                            <td><?= htmlspecialchars($service['service']) ?></td>
                            <td><?= htmlspecialchars($service['reason']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
            <nav>
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
            </li>
        <?php endif; ?>

        <li class="page-item disabled">
            <span class="page-link">Page <?= $page ?> of <?= $totalPages ?></span>
        </li>

        <?php if ($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

            <div class="text-center">
                <button class="btn btn-primary" onclick="generatePDF()">Generate PDF</button>
            </div>
        </div>
    </div>
    <script>
    async function generatePDF() {
        const { jsPDF } = window.jspdf;
        let pdf = new jsPDF("p", "mm", "a4");

        // Capture the chart as an image
        let chartCanvas = document.getElementById("reportChart");
        let chartImage = await html2canvas(chartCanvas).then(canvas => canvas.toDataURL("image/png"));

        // Add Title
        pdf.setFontSize(18);
        pdf.text("Appointment Report", 10, 10);

        // Add Chart to PDF
        pdf.addImage(chartImage, "PNG", 10, 20, 180, 80); // X, Y, Width, Height

        // Move to table section
        pdf.setFontSize(14);
        pdf.text("Appointment Details", 10, 110);

        // Extract table headers and rows
        let table = document.querySelector("table");
        let headers = [];
        let body = [];

        // Get table headers
        table.querySelectorAll("thead th").forEach(th => {
            headers.push(th.innerText);
        });

        // Get table rows
        table.querySelectorAll("tbody tr").forEach(tr => {
            let rowData = [];
            tr.querySelectorAll("td").forEach(td => {
                rowData.push(td.innerText);
            });
            body.push(rowData);
        });

        // Add table using autoTable()
        pdf.autoTable({
            startY: 120, // Start table below the chart
            head: [headers],
            body: body,
            theme: 'striped',
            styles: {
                fontSize: 10,
                cellPadding: 2,
                overflow: 'linebreak',
            },
            headStyles: {
                fillColor: [40, 167, 69], // Bootstrap success green
                textColor: 255
            },
            margin: { top: 120 }
        });

        // Save PDF
        pdf.save("appointment_report.pdf");
    }
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let services = <?= json_encode($services['chart_services']) ?>;
            let counts = <?= json_encode($services['counts']) ?>;

            let ctx = document.getElementById("reportChart").getContext("2d");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: services,
                    datasets: [{
                        label: "Number of Appointments",
                        data: counts,
                        backgroundColor: ["#28a745", "#007bff", "#ff9900"],
                        borderColor: "#ffffff",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
        
        // function generatePDF() {
        //     window.location.href = "generate_pdf.php";
        // }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


</html>
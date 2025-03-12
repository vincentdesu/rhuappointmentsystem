<?php
require_once('admin_functions.php');
$admin_functions->schedule_and_slots();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-success p-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="logo.png" alt="Logo" width="30" class="me-2">
                <span>Rural Health Unit I</span>
            </a>
            <button class="btn btn-primary">Logout</button>
        </div>
    </nav>
    
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link active bg-primary text-white">Schedules and Slots</a></li>
            </ul>
        </div>
        
        <!-- Content -->
        <div class="container p-4">
            <h2>Manage Schedule and Slots</h2>
            <div class="card p-4 shadow-sm">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="service" class="form-label">Choose a service:</label>
                        <select id="service" name="service" class="form-select">
                            <option value="checkup">Check Up</option>
                            <option value="dentalcares">Dental Cares</option>
                            <option value="animalbites">Animal Bites</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="start-date" class="form-label">Date:</label>
                        <input type="date" id="start-date" name="start-date" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="timeofschedule" class="form-label">Time of Schedule:</label>
                        <select id="timeofschedule" name="timeofschedule" class="form-select" required>
                            <option value="">-- Select Time --</option>
                            <option value="9">9:00 AM</option>
                            <option value="10">10:00 AM</option>
                            <option value="11">11:00 AM</option>
                            <option value="2">2:00 PM</option>
                            <option value="3">3:00 PM</option>
                            <option value="4">4:00 PM</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="slots" class="form-label">Set amount of slots:</label>
                        <input type="number" id="slots" name="slots" class="form-control">
                    </div>
                    
                    <button type="submit" name="changesched" class="btn btn-success w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
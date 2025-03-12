<?php
require_once('admin_functions.php');
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
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white active bg-primary text-white">Send SMS</a></li> 
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
            </ul>
        </div>
        
        <!-- Content -->
        <div class="container p-4">
            <h2>Send SMS</h2>
            <div class="card p-4 shadow-sm">
                <form action="" method="POST">
                    <button type="submit" name="changesched" class="btn btn-success w-100">Send</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
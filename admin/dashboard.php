<?php
require_once('admin_functions.php');
$total_users = $admin_functions->count_users();
$total_complete = $admin_functions->count_completed();
$total_ongoing = $admin_functions->count_ongoing();
$total_cancelled = $admin_functions->count_cancelled();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="bootstraps/adminlte.js"></script>

    
    <style>
        .small-box {
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            min-height: 100px;
        }
        .small-box .inner h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        .small-box .inner p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        .small-box-icon {
            width: 40px;
            height: 40px;
        }
        .small-box-footer {
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
<div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="logo.png" alt="Logo" width="30" class="d-inline-block align-text-top">
                    Rural Health Unit I
                </a>
                <button class="btn btn-primary">Logout</button>
            </div>
        </nav>

        <div class="d-flex">
        <nav class="bg-dark text-white p-3 min-vh-100 d-flex flex-column" style="width: 250px;">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link text-white active bg-primary">Dashboard</a></li>
                    <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                    <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                    <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                    <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                    <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                    <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                    <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
                </ul>
            </nav>
            <div class="container mt-3">
            <div class="row g-3">
            <div class="col-md-3 col-6">
                <a href="" class="text-decoration-none">
                    <div class="card text-bg-primary text-center p-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title"><?= $total_users ?></h3>
                            <p class="card-text">Accounts</p>
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="ad report.php" class="text-decoration-none">
                    <div class="card text-bg-success text-center p-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title"><?= $total_complete ?></h3>
                            <p class="card-text">Completed Appointments</p>
                            <i class="bi bi-graph-up fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="appointment.php" class="text-decoration-none">
                    <div class="card text-bg-warning text-center p-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title"><?= $total_ongoing ?></h3>
                            <p class="card-text">Ongoing Appointments</p>
                            <i class="bi bi-hourglass-split fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-6">
                <a href="" class="text-decoration-none">
                    <div class="card text-bg-danger text-center p-3 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title"><?= $total_cancelled ?></h3>
                            <p class="card-text">Rejected/Cancelled</p>
                            <i class="bi bi-x-circle fs-1"></i>
                        </div>
                    </div>
                </a>
            </div>

            </div>
</div>

</body>
</html>

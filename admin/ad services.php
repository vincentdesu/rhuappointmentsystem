<?php 
require_once('admin_functions.php');
$services = $admin_functions->services();
$admin_functions->servicelist_edit();
$admin_functions->servicelist_delete();
$admin_functions->servicelist_add();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logo.png" alt="Logo" width="30" class="me-2">
            Rural Health Unit I
        </a>
        <button class="btn btn-info ms-auto">Logout</button>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white active bg-primary">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
            </ul>
        </div>

            <!-- Content -->
            <main class="col-md-10 p-4">
                <h2 class="mb-4">Services List</h2>
                
                <!-- Service Table -->
                <form action="update_services.php" method="POST">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>Service</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $service) { ?>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="id[]" value="<?= $service['id']; ?>">
                                            <input type="text" name="services[]" value="<?= $service['service']; ?>" class="form-control">
                                        </td>
                                        <td>
                                            <button type="submit" name="update" value="<?= $service['id']; ?>" class="btn btn-success btn-sm">Save</button>
                                            <button type="submit" name="delete" value="<?= $service['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Add New Service Form -->
                <h3 class="mt-4">Add New Service</h3>
                <form action="update_services.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="new_service" placeholder="Service Name" required class="form-control">
                    </div>
                    <div class="col-12">
                        <button type="submit" name="add" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
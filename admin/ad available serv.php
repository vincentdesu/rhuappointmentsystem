<?php
require_once('admin_functions.php');
$services = $admin_functions->show_services();
$admin_functions->services_edit();
$admin_functions->services_delete();
$admin_functions->add_services();

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
        <nav class="bg-dark text-white p-3 vh-100" style="width: 250px;">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white active bg-primary ">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
            </ul>
        </nav>

        <div class="container-fluid p-4">
            <h2 class="mb-4">Available Services</h2>

            <form action="" method="POST" class="mb-4">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Doctor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service) { ?>
                                <tr>
                                    <td><input type="hidden" name="id[]" value="<?= $service['id']; ?>">
                                        <input type="text" name="services[]" value="<?= $service['services']; ?>" class="form-control"></td>
                                    <td><input type="text" name="status[]" value="<?= $service['status']; ?>" class="form-control"></td>
                                    <td><input type="text" name="doc[]" value="<?= $service['doc']; ?>" class="form-control"></td>
                                    <td>
                                        <button type="submit" name="update" value="<?= $service['id']; ?>" class="btn btn-success">Save</button>
                                        <button type="submit" name="delete" value="<?= $service['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <h3>Add New Service</h3>
            <form action="" method="POST" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="new_service" class="form-control" placeholder="Service Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="new_status" class="form-control" placeholder="Status (active/inactive)" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="new_doc" class="form-control" placeholder="Doctor Name" required>
                </div>
                <div class="col-12">
                    <button type="submit" name="add" class="btn btn-primary">Add Service</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
require_once('admin_functions.php');
if (isset($_GET['submit'])) {
    $accounts = $admin_functions->show_accounts_filtered();
} else {
    $accounts = $admin_functions->show_accounts();
}

$admin_functions->approve();
$admin_functions->reject();

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-success px-3">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logo.png" alt="Logo" width="30" class="me-2"> Rural Health Unit I
        </a>
        <button class="btn btn-primary ms-auto">Logout</button>
    </nav>
    
    <div class="d-flex">
    <nav class="bg-dark text-white p-3 min-vh-100 d-flex flex-column" style="width: 250px;">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="appointment.php" class="nav-link text-white">Appointments</a></li>
                <li class="nav-item"><a href="ad pending.php" class="nav-link text-white active bg-primary">Pending Accounts</a></li>
                <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
                <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
                <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
                <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
                <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
            </ul>
        </nav>
        
        <div class="container-fluid p-4">
            <h2 class="mb-4">Pending Accounts</h2>
            
            <form class="row g-3 mb-4" method = "GET">
                <div class="col-md-4">
                    <label for="service" class="form-label">Search</label>
                    <input type="text" id="service" name="service" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="start-date" class="form-label">Date</label>
                    <input type="date" id="start-date" name="start-date" class="form-control" >
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" name = "submit">Submit</button>
                </div>
            </form>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Address</th>
                            <th>Age</th>
                            <th>Birthdate</th>
                            <th>ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accounts as $account) { ?>
                        <tr>
                            <td><?= htmlspecialchars($account['date']); ?></td>
                            <td><?= htmlspecialchars($account['lastname']); ?></td>
                            <td><?= htmlspecialchars($account['firstname']); ?></td>
                            <td><?= htmlspecialchars($account['middlename']); ?></td>
                            <td><?= htmlspecialchars($account['address']); ?></td>
                            <td><?= htmlspecialchars($account['age']); ?></td>
                            <td><?= htmlspecialchars($account['dateofbirth']); ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="viewImage('uploads/<?= htmlspecialchars($account['fileid']); ?>')">View</button>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="user_id" value="<?= $account['id']; ?>">
                                    <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                                    <button type="submit" name="reject" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div id="imageModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="img-fluid" alt="ID Image">
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewImage(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            myModal.show();
        }
    </script>
</body>
</html>
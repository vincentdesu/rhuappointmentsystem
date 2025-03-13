<?php
require_once('admin_functions.php');

$admin_functions->edit_appointments();
$admin_functions->remove_appointments();
if (isset($_GET['submit'])) {
    $lists = $admin_functions->show_appoints_filtered();
} else {
    $lists = $admin_functions->show_appoints();
}

// Define the number of records per page
$records_per_page = 10;

// Get the current page number from the GET request (default to 1 if not set)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate the offset for the database query
$offset = ($page - 1) * $records_per_page;

// Fetch the total number of records
$total_records = count($lists); // Assuming $lists contains all data
$total_pages = ceil($total_records / $records_per_page);

// Slice the array to get only the current page's data
$current_page_lists = array_slice($lists, $offset, $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>

</style>
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
    <ul class="nav flex-column flex-grow-1">
        <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
        <li class="nav-item"><a href="appointment.php" class="nav-link text-white active bg-primary">Appointments</a></li>
        <li class="nav-item"><a href="ad pending.php" class="nav-link text-white">Pending Accounts</a></li>
        <li class="nav-item"><a href="ad available serv.php" class="nav-link text-white">Available Services</a></li>
        <li class="nav-item"><a href="ad sched.php" class="nav-link text-white">Schedules</a></li>
        <li class="nav-item"><a href="ad services.php" class="nav-link text-white">Services</a></li>
        <li class="nav-item"><a href="ad report.php" class="nav-link text-white">Report</a></li>
        <li class="nav-item"><a href="ad sched and slot.php" class="nav-link text-white">Schedules and Slots</a></li>
    </ul>
</nav>

        
            <div class="container-fluid p-4">
    <h2>Ongoing Appointments</h2>
    <div class="card p-4">
        <form class="row g-3" method="GET">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="service" class="form-label">Choose a service:</label>
                <select id="service" name="service" class="form-select">
                    <option value="checkup">Check Up</option>
                    <option value="dentalcares">Dental Cares</option>
                    <option value="animalbites">Animal Bites</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="start-date" class="form-label">Date:</label>
                <input type="date" id="start-date" name="start-date" class="form-control">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success" name="submit">Submit</button>
            </div>
        </form>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th>Full Name</th>
                    <th>Service</th>
                    <th>Date Schedule</th>
                    <th>Time Schedule</th>
                    <th>Message</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($current_page_lists as $list) { ?>
                <tr>
                    <td><?= htmlspecialchars($list['fullname']) ?></td>
                    <td><?= htmlspecialchars($list['service']) ?></td>
                    <td><?= htmlspecialchars($list['schedule_date']) ?></td>
                    <td><?= htmlspecialchars($list['time_slot']) ?></td>
                    <td><?= htmlspecialchars($list['reason']) ?></td>
                    <td><?= htmlspecialchars($list['code']) ?></td>
                    <td>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-id="<?= $list['id']; ?>"
                            data-fullname="<?= htmlspecialchars($list['fullname']); ?>"
                            data-service="<?= htmlspecialchars($list['service']); ?>"
                            data-schedule="<?= htmlspecialchars($list['schedule_date']); ?>"
                            data-timeslot="<?= htmlspecialchars($list['time_slot']); ?>"
                            data-reason="<?= htmlspecialchars($list['reason']); ?>"
                            data-code="<?= htmlspecialchars($list['code']); ?>">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                            data-bs-target="#deleteModal"
                            data-id="<?= $list['id']; ?>"
                            data-fullname="<?= htmlspecialchars($list['fullname']); ?>">
                            Remove
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
                </li>
            <?php } ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php } ?>
            <?php if ($page < $total_pages) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
 <!-- Edit Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" id="edit-id" name="id">
                                            <div class="mb-3">
                                                <label for="edit-fullname" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="edit-fullname" name="fullname" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-service" class="form-label">Service</label>
                                                <input type="text" class="form-control" id="edit-service" name="service" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-schedule" class="form-label">Schedule Date</label>
                                                <input type="date" class="form-control" id="edit-schedule" name="schedule_date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-timeslot" class="form-label">Time Slot</label>
                                                <input type="text" class="form-control" id="edit-timeslot" name="time_slot" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-reason" class="form-label">Reason</label>
                                                <textarea class="form-control" id="edit-reason" name="reason" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="edit-code" class="form-label">Code</label>
                                                <input type="text" class="form-control" id="edit-code" name="code" readonly>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary" name = "save">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" id="delete-id" name="id">
                                            <p>Are you sure you want to delete <strong id="delete-name"></strong>'s appointment?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger" name = "delete">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Edit Modal
        var editModal = document.getElementById("editModal");
        editModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            document.getElementById("edit-id").value = button.getAttribute("data-id");
            document.getElementById("edit-fullname").value = button.getAttribute("data-fullname");
            document.getElementById("edit-service").value = button.getAttribute("data-service");
            document.getElementById("edit-schedule").value = button.getAttribute("data-schedule");
            document.getElementById("edit-timeslot").value = button.getAttribute("data-timeslot");
            document.getElementById("edit-reason").value = button.getAttribute("data-reason");
            document.getElementById("edit-code").value = button.getAttribute("data-code");
        });

        // Delete Modal
        var deleteModal = document.getElementById("deleteModal");
        deleteModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            document.getElementById("delete-id").value = button.getAttribute("data-id");
            document.getElementById("delete-name").textContent = button.getAttribute("data-fullname");
        });
    });
</script>
</html>

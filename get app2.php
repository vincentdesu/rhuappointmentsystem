<?php
require_once('functions.php');
$lists = $functions->show_appoints();
$functions->edit_appointment();
$functions->remove_appointment();

$userdata = $functions->get_userdata();
$status = $userdata['status']; 

if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
    if($status === 'pending')
    echo '<script>
        alert("Please login");
        window.location.href = "login.php";
    </script>';
    exit(); // Stop execution after redirect
}

$pdo = new PDO("mysql:host=localhost;dbname=appointmentsystem", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$itemsPerPage = 10;

// Get current page from URL, default to 1
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1

// Calculate offset
$offset = ($page - 1) * $itemsPerPage;

// Fetch total number of records
$stmt = $pdo->query("SELECT COUNT(*) FROM appointments");
$totalRows = $stmt->fetchColumn();
$totalPages = ceil($totalRows / $itemsPerPage);

// Fetch paginated data
$stmt = $pdo->prepare("SELECT * FROM appointments ORDER BY schedule_date DESC LIMIT :offset, :items");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':items', $itemsPerPage, PDO::PARAM_INT);
$stmt->execute();
$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit I Appointment System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            text-align: center;
            background: url('bg.png') center/cover no-repeat;
            /* Body background image */
            min-height: 100vh;
            /* Ensure the body fills the entire viewport */
            color: #333;
        }

        .header {
            background-color: #2E7D32;
            padding: 15px;
            color: white;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header img {
            height: 50px;
            width: auto;
            margin-left: 15px;
        }

        .header nav {
            text-align: right;
            flex-grow: 1;
            animation: slideRightToLeft 1s ease-in-out;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
            transition: color 0.3s, transform 0.3s;
            display: inline-block;
        }

        .header a:hover {
            color: #C8E6C9;
            transform: scale(1.1);
        }

        .hero {
            position: relative;
            height: 100vh;
            background: url('bg.png') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46, 125, 50, 0.7);
        }

        .hero h1 {
            font-size: 3rem;
            position: relative;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        .appointment-btn {
            margin-top: 20px;
            padding: 15px 30px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            position: relative;
            transition: transform 0.3s, background-color 0.3s;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        .appointment-btn:hover {
            transform: scale(1.1);
            background-color: #388E3C;
        }

        .footer {
            background-color: #2E7D32;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
        }

        .footer p {
            animation: slideUp 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideRightToLeft {
            from {
                transform: translateX(50px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .services {
            padding: 50px 20px;
            color: #333;
            background: rgba(46, 125, 50, 0.7);
            /* Light white background with transparency */
            min-height: 800px;
            max-height: 1000px;
            justify-content: center;
            align-items: center;
        }

        .services-box {
            background-color: white;
            /* White background for the box */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            /* Make the box width responsive */
            max-width: 1200px;
            /* Maximum width of the box */
        }

        .services h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: white;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        .service-box {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        .service-box p {
            background-color: #ffffff;
            border: 2px solid #2E7D32;
            border-radius: 10px;
            padding: 15px;
            font-size: 1.2rem;
            color: #333;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.3s;
        }

        .service-box p strong {
            font-weight: bold;
            color: #2E7D32;
        }

        .service-box p:hover {
            background-color: #E8F5E9;
            transform: scale(1.05);
        }

        .service-box p:not(:last-child) {
            margin-bottom: 15px;
        }

        /* General table styling */
        table {
            width: 80%;
            /* You can adjust this value as needed */
            margin: 0 auto;
            /* This centers the table horizontally */
            border-collapse: collapse;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        /* Other existing table styles (No changes here) */
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 1.1rem;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            padding: 5px 10px;
            font-size: 1rem;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Add arrow indicators to header */
        th:after {
            content: ' ▼';
            /* Default to descending arrow */
            font-size: 0.8rem;
            margin-left: 5px;
        }

        th.asc:after {
            content: ' ▲';
            /* Ascending arrow */
        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <nav>
            <a href="home.php">HOME</a> |
            <a href="available service.php">AVAILABLE DOCTORS</a> |
            <a href="schedules.php">SCHEDULES</a> |
            <a href="services.php">SERVICES</a> |
            <a href="get app.php">GET APPOINTMENT</a> |
            <a href="get app2.php">VIEW APPOINTMENT</a> |
            <a href="profile_account.php">MY PROFILE</a> |
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>
    <div class="services">
        <center>
        <b><h1>View Appointment/s</h1></b>
        </center>
        <table id="appointmentTable" border="1" cellpadding="10" cellspacing="0"
            style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Full Name</th>
                    <th onclick="sortTable(1)">Service</th>
                    <th onclick="sortTable(2)">Date Schedule</th>
                    <th onclick="sortTable(3)">Time Schedule</th>
                    <th onclick="sortTable(4)">Message</th>
                    <th onclick="sortTable(5)">Code</th>
                    <th onclick="sortTable(6)">Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
            <?php foreach($lists as $list){ ?>
                
                <tr>
                    <td><?= htmlspecialchars($list['fullname']); ?></td>
                    <td><?= htmlspecialchars($list['service']); ?></td>
                    <td><?= htmlspecialchars($list['schedule_date']); ?></td>
                    <td><?= htmlspecialchars($list['time_slot']); ?></td>
                    <td><?= htmlspecialchars($list['reason']); ?></td>
                    <td><?= htmlspecialchars($list['code']); ?></td>
                    <td><?= htmlspecialchars($list['status']); ?></td>
                
                    <td>
                    <?php $isCompleted = ($list['status'] === 'Completed') ? 'disabled' : ''; ?>

                        <!-- Edit Button -->
                        <button type="button" class="btn btn-success edit-btn" 
                            data-id="<?= $list['id'] ?>"
                            data-fullname="<?= $list['fullname'] ?>"
                            data-service="<?= $list['service'] ?>"
                            data-schedule="<?= $list['schedule_date'] ?>"
                            data-time="<?= $list['time_slot'] ?>"
                            data-reason="<?= $list['reason'] ?>"
                            data-status="<?= $list['status'] ?>"
                            data-bs-toggle="modal" data-bs-target="#editModal"
                            <?= $isCompleted; ?>>Edit</button>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <input type="hidden" id="edit-id" name="id">

                                            <div class="mb-3">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="edit-fullname" name="fullname" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit-service" class="form-label">Choose a Service:</label>
                                                <select id="edit-service" name="service" class="form-control" required>
                                                    <option value="">-- Select Service --</option>
                                                    <option value="checkup">Check Up</option>
                                                    <option value="dentalcares">Dental Cares</option>
                                                    <option value="animalbites">Animal Bites</option>
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label">Schedule Date</label>
                                                <input type="date" class="form-control" id="edit-schedule" name="schedule_date" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit-time" class="form-label">Time of Schedule:</label>
                                                <select id="edit-time" name="time_slot" class="form-control" required>
                                                    <option value="">-- Select Time --</option>
                                                    <option value="9">9:00 AM</option>
                                                    <option value="10">10:00 AM</option>
                                                    <option value="11">11:00 AM</option>
                                                    <option value="14">2:00 PM</option>
                                                    <option value="15">3:00 PM</option>
                                                    <option value="16">4:00 PM</option>
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <textarea class="form-control" id="edit-reason" name="reason"></textarea>
                                            </div>


                                            <button type="submit" class="btn btn-primary" name = "edit">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remove Button -->
                                    <button type="button" class="btn btn-danger delete-btn" 
                data-id="<?= $list['id'] ?>"
                data-bs-toggle="modal" data-bs-target="#deleteModal"
                <?= $isCompleted; ?>>Remove</button>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this appointment?</p>
                                        <form action="" method="POST">
                                            <input type="hidden" id="delete-id" name="id">
                                            <button type="submit" class="btn btn-danger" name = "delete">Delete</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table><br><br>
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
    </div>

    <footer>
        <div class="footer">
            <p>ALL RIGHTS RESERVED 2025</p>
        </div>
    </footer>
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
                document.getElementById("edit-time").value = button.getAttribute("data-time");
                document.getElementById("edit-reason").value = button.getAttribute("data-reason");
                document.getElementById("edit-status").value = button.getAttribute("data-status");
            });

            // Delete Modal
            var deleteModal = document.getElementById("deleteModal");
            deleteModal.addEventListener("show.bs.modal", function (event) {
                var button = event.relatedTarget;
                document.getElementById("delete-id").value = button.getAttribute("data-id");
            });
        });
        let lastSortedColumn = -1;
        let lastSortDirection = "asc"; // Default to ascending order

        function sortTable(columnIndex) {
            var table = document.getElementById("appointmentTable");
            var rows = table.rows;
            var switching = true;
            var dir = lastSortedColumn === columnIndex && lastSortDirection === "asc" ? "desc" : "asc"; // Toggle direction

            // Reset all columns' arrow indicators
            Array.from(table.querySelectorAll('th')).forEach(th => th.classList.remove('asc', 'desc'));

            // Set arrow for the current sorted column
            table.rows[0].cells[columnIndex].classList.add(dir);

            // Loop until no switching is needed
            while (switching) {
                switching = false;
                var rowsArray = Array.from(rows).slice(1); // Get rows except the header row

                // Loop through all table rows
                for (var i = 0; i < rowsArray.length - 1; i++) {
                    var row1 = rowsArray[i];
                    var row2 = rowsArray[i + 1];
                    var cell1 = row1.cells[columnIndex];
                    var cell2 = row2.cells[columnIndex];

                    // Check if the rows should be switched based on the sorting direction
                    var shouldSwitch = false;
                    if (dir === "asc") {
                        if (cell1.innerText.toLowerCase() > cell2.innerText.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir === "desc") {
                        if (cell1.innerText.toLowerCase() < cell2.innerText.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rowsArray[i].parentNode.insertBefore(rowsArray[i + 1], rowsArray[i]);
                    switching = true;
                } else {
                    switching = false;
                }
            }

            // Update the last sorted column and direction
            lastSortedColumn = columnIndex;
            lastSortDirection = dir; // Toggle the sort direction for the next click
        }

    </script>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
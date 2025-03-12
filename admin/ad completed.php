<?php
require_once('admin_functions.php');
$lists = $admin_functions->show_appoints_completed();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #2c7c3f;
            color: white;
            padding: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .header img {
            width: 30px;
            margin-right: 10px;
        }

        .logout {
            background-color: #49b5ff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin-left: auto;
            cursor: pointer;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 200px;
            background: #eeeeee;
            padding: 20px;
            height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .sidebar ul li:hover,
        .sidebar ul li.active {
            background: #cccccc;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .box {
            background: #ddd;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .save-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #2c7c3f;
            color: white;
            text-align: center;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* General container styling */
        .container {
            display: flex;
            font-family: Arial, sans-serif;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding: 20px;
            color: white;
            height: 100vh;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 12px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul a:hover {
            background-color: #34495e;
        }

        .sidebar ul a .active {
            background-color: #1abc9c;
        }

        /* Content section styling */
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #ecf0f1;
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Textarea box styling */
        .box {
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            height: 400px;
            font-size: 14px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }

        textarea:focus {
            outline: none;
            border-color: #1abc9c;
        }

        /* Save button styling */
        .save-btn {
            background-color: #1abc9c;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .save-btn:hover {
            background-color: #16a085;
        }

        /* General form styling */
        form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Labels */
        label {
            font-weight: bold;
            margin-right: 5px;
        }

        /* Dropdown and input fields */
        select,
        input[type="date"],
        input[type="text"],
        input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Search button styling */
        .save-btn {
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-btn:hover {
            background-color: #16a085;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-family: Arial, sans-serif;
        }

        /* Header styling */
        th {
            background-color: #1abc9c;
            color: white;
            padding: 10px;
            text-align: left;
        }

        /* Row styling */
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        /* Alternate row background */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #d1f0e0;
            transition: 0.3s;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            form {
                flex-direction: column;
                align-items: flex-start;
            }

            select,
            input[type="date"],
            .save-btn {
                width: 100%;
            }
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #1abc9c;
            color: white;
            padding: 10px 15px;
            text-align: center;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #16a085;
        }

        /* Button styling */
        button {
            background-color: #1abc9c;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .delete {
            background-color: red;
        }

        /* Hover effect */
        button:hover {
            background-color: #16a085;
            transform: scale(1.05);
        }

        /* Active (click) effect */
        button:active {
            background-color: #12876f;
            transform: scale(0.98);
        }

        /* Disabled button */
        button:disabled {
            background-color: #bdc3c7;
            cursor: not-allowed;
        }

        /* Full-width button for mobile */
        @media screen and (max-width: 600px) {
            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <span>Rural Health Unit I</span>
        <span class="logout">Logout</span>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <a href="ad completed.php">
                    <li class="active">Completed Appointments</li>
                </a>
                <a href="appointment.php">
                    <li>Appointments</li>
                </a>
                <a href="ad pending.php">
                    <li>Pending Accounts</li>
                </a>
                <a href="ad available serv.php">
                    <li>Available Services</li>
                </a>
                <a href="ad sched.php">
                    <li>Schedules</li>
                </a>
                <a href="ad services.php">
                    <li>Services</li>
                </a>
                <a href="ad report.php">
                    <li>Report</li>
                </a>
                <a href="ad sched and slot.php">
                    <li>Schedules and Slots</li>
                </a>
            </ul>
        </div>
        <div id="appointments" class="content">
            <h2>Ongoing Appointments</h2>
            <div class="box">
                <form>
                    <label for="service">Search</label>
                    <input type="text" id="service" name="service">
                    <label for="service">Choose a service:</label>
                    <select id="service" name="service">
                        <option value="checkup">Check Up</option>
                        <option value="dentalcares">Dental Cares</option>
                        <option value="animalbites">Animal Bites</option>
                    </select> <label for="start-date">Date:</label>
                    <input type="date" id="start-date" name="start-date" required>
                    <input type="submit" value="Submit">
                </form>
                
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
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($lists as $list){?>
                        <tr>
                            <td><?= $list['fullname'] ?></td>
                            <td><?= $list['service'];?></td>
                            <td><?= $list['schedule_date'];?></td>
                            <td><?= $list['time_slot'];?></td>
                            <td><?= $list['reason'];?></td>
                            <td><?= $list['code'];?></td>

                            <td>
                                <?= $list['status'] ?>
                            </td>  
                        </tr>
                <?php }?>

                        <!-- More rows can be added here -->
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</body>



</html>
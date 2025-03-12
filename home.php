<?php
require_once('functions.php');

$userdata = $functions->get_userdata();

$status = $userdata['status'];

// Check if user is logged in
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
    echo '<script>
        alert("Please login");
        window.location.href = "login.php";
    </script>';
    exit(); // Stop execution after redirect
}

$userdetails = $functions->getUsers(); // Get user details if logged in
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

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
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
    </style>
</head>

<body>
    <div class="header">
        <img src="logo.png" alt="Logo">
        <nav>
            <a href="home.php">HOME</a> |
            <a href="available service.php">AVAILABLE DOCTORS</a> |
            <a href="schedules.php">SCHEDULES</a> |
            <a href="services.php">SERVICES</a> |
            <?php 
                if ($status === 'approved') {
                    ?>
                    <a href="get app.php">GET APPOINTMENT</a> |
                    <a href="get app2.php">VIEW APPOINTMENT</a> |
                    <?php
                }
            ?>
            <a href="profile_account.php">MY PROFILE</a> |
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>
    <div class="hero">
        <h1>Rural Health Unit I Appointment System</h1>
        <a href="get app.php"><button class="appointment-btn">CLICK HERE AND GET APPOINTMENT</button></a>
        <a href="kiosk/kioskmain.html"><button class="appointment-btn">KIOSK MODE</button></a>
        <a href="admin/appointment.php"><button class="appointment-btn">ADMIN MODE</button></a>

    </div>
    <footer>
        <div class="footer">
            <p>ALL RIGHTS RESERVED 2025</p>
        </div>
    </footer>
</body>

</html>
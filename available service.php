<?php 
require_once('functions.php');
$userdata = $functions->get_userdata();

$status = $userdata['status'];

$services = $functions->show_services();
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
            <?php if($status === "approved"){ ?>
            <a href="get app.php">GET APPOINTMENT</a> |
            <a href="get app2.php">VIEW APPOINTMENT</a> |
            <?php } ?>
            <a href="profile_account.php">MY PROFILE</a> |
            <a href="login.php">LOGOUT</a>
        </nav>
    </div>
    <div class="services">
        <h1>Available Doctors</h1>
        <div class="service-box">
        <?php foreach ($services as $service) { ?>
            <p><strong><?= $service['services']; ?></strong> - <?= $service['status'];?> - <?= $service['doc'];?> </p>
        <?php } ?>
        </div>
    </div>
    <footer>
        <div class="footer">
            <p>ALL RIGHTS RESERVED 2025</p>
        </div>
    </footer>
</body>

</html>
<?php
require_once('functionskiosk.php');
$kiosk_functions->code();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit I Kiosk</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: url(bg.png) no-repeat center center/cover;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        /* Background overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46, 125, 50, 0.7); /* Greenish overlay */
            z-index: -1;
        }

        /* Main container */
        .container {
            text-align: center;
            position: relative;
            z-index: 1; /* Ensures the content appears above the overlay */
        }

        /* Logo styling */
        .logo {
            width: 250px;
            height: auto;
            margin-bottom: 20px;
        }

        /* Title styling */
        .header h1 {
            font-size: 50px;
            color: white;
            margin: -30px 0 30px;
        }

        /* Button container */  

        /* Buttons color */
        .input-code,
        .create-appointment {
            background-color: #3498db;
            color: white;
        }

        .create-appointment {
            background-color: #2ecc71;
        }

        /* Hover effects */
        .input-code:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .create-appointment:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        /* Button images */
        .input-code .button-img,
        .create-appointment .button-img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        /* Form container */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
        }

        /* Input field styling */
        input[type="text"] {
            width: 280px;
            height: 45px;
            font-size: 18px;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            text-align: center;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        /* Input focus effect */
        input[type="text"]:focus {
            border-color: #2980b9;
            box-shadow: 0 0 8px rgba(41, 128, 185, 0.5);
        }

        /* Label styling */
        label {
            font-size: 20px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            .button-container {
                flex-direction: column;
            }

            button {
                width: 90%;
                height: 120px;
            }

            .input-code .button-img,
            .create-appointment .button-img {
                width: 80px;
            }

            .logo {
                width: 200px;
            }

            .header h1 {
                font-size: 40px;
            }
        }
        /* Submit button styling */
        input[type="submit"] {
            width: 200px;
            height: 50px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background-color: #2ecc71; /* Green color */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 15px;
        }

        /* Hover effect */
        input[type="submit"]:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        /* Active (clicked) effect */
        input[type="submit"]:active {
            background-color: #1e8449;
            transform: scale(0.98);
        }
/* Button-like styling for the <a> tag */
a {
    display: inline-block;
    padding: 12px 24px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    color: white;
    background-color: #e74c3c; /* Red color */
    border-radius: 8px;
    transition: background-color 0.3s, transform 0.2s;
}

/* Hover effect */
a:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

/* Active (clicked) effect */
a:active {
    background-color: #a93226;
    transform: scale(0.98);
}

</style>

<body>
    <div class="container">
        <!-- Logo and Title -->
        <div class="header">
            <img src="logo.png" alt="RHU Logo" class="logo">
            <h1 style="font-size: 60px; margin-top: -50px; margin-bottom: -50px;">Rural Health Unit I <br>KIOSK</h1><br><br><hr>
        </div>

      
        <div class="button-container">
            
                <form action = "" method = "POST">
                    <label for = "code">Enter the code</label>
                    <input type = "text" name = "code">
                    <input type = "submit" name = "submit" value = "Submit"><br>
                    <a href = "kioskmain.html">Back</a>
                </form>
        </div>


    </div>
</body>

</html>
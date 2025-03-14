<?php
    require_once('functions.php');

    if (isset($_SESSION['userdata'])) {
        echo '<script>
            window.location.href = "home.php";
        </script>';
        exit(); // Stop execution after redirect
    }
    $functions->find_username();
?>

<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment System</title>
</head>
<style>
    * {
        font-family: Arial, sans-serif;
    }

    body {
        margin-top: 25px;
        background-image: url(bg.png);
        background-repeat: no-repeat;
        background-size: cover;
        margin-bottom: 25px;
    }


    #login {
        background-color: white;
        padding: 80px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 80%;
    }

    h1 {
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    /* .row {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10%;
        
    } */

    .forgot-password {
        text-align: right;
        width: 100%;
    }

    .logintitle,
    img {
        margin-top: 100px;
    }

    .dont {
        margin-bottom: 200px;
    }
</style>

<body>
    <div class="container" id = "logincall">
        <div class="row">
            <div class="col">
                <div id="login" name="login">
                    <h1 class="logintitle text-center">Reset password</h1>
                    </br>
                    <form action = "" method = "POST">
                        <label for="username">Enter username</label><br>
                        <input type="text" id="username" name="username"><br>

                        <br>
                        <input type="submit" value="Find" name = "find">
                    </form>
                    </br></br>
                    <p class="dont text-center">Did you remember your password? <a href="login.php">Login here!</a></p>
                </div>
            </div>
            <div class="col text-center">
                <div name="logo">
                    <img src="456824869_912959037542938_2249134743186522110_n-removebg-preview.png" height="50%"
                        width="50%">
                    <h1 style="color: white; font-size: 36px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);">Rural Health
                        Unit I <br> Appointment System</h1>

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container" id = "codecall" hidden>
        <div class="row">
            <div class="col">
                <div id="login" name="login">
                    <h1 class="logintitle text-center">Reset password</h1>
                    </br>
                    <form action = "" method = "POST">
                        <label for="username">Enter username</label><br>
                        <input type="text" id="username" name="username"><br>

                        <br>
                        <input type="submit" value="Login" name = "login" onclick="showReminder()">
                    </form>
                    </br></br>
                    <p class="dont text-center">Did you remember your password? <a href="login.php">Login here!</a></p>
                </div>
            </div>
            <div class="col text-center">
                <div name="logo">
                    <img src="456824869_912959037542938_2249134743186522110_n-removebg-preview.png" height="50%"
                        width="50%">
                    <h1 style="color: white; font-size: 36px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);">Rural Health
                        Unit I <br> Appointment System</h1>

                </div>
            </div>
        </div>
    </div> -->
</body>
<script>
    function showReminder() {
        document.getElementById("logincall").classList.add("hidden");
        document.getElementById("codecall").classList.remove("hidden");

    }
</script>
</html>
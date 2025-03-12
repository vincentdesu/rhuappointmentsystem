<?php
require_once('functions.php');
$functions->register();
if (isset($_SESSION['userdata'])) {
    echo '<script>
        window.location.href = "home.php";
    </script>';
    exit(); // Stop execution after redirect
}
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
    <title>Registration </title>
</head>
<style>
    * {
        font-family: Arial, sans-serif;
    }

    h1 {
        font-weight: bold;
        text-align: center;
    }

    body {
        background-image: url(bg.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .Register {
        background-color: white;
        width: 100%;
        padding: 100px;
        margin-right: 100px;

    }

    input[type="text"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    input[type="file"] {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;

    }

    input[type="submit"] {
        width: 50%;
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
</style>

<body>

    <center><img src="456824869_912959037542938_2249134743186522110_n-removebg-preview.png" width="200"></center>
    <h1 style="color: white; font-size: 36px; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);">Rural Health
        Unit I <br> Appointment System</h1>

    <div class="Register">

        <h1>Register</h1>
        <form action="" method = "POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <label for="lastname">Last name</label><br>
                    <input type="text" id="lastname" name="lastname" required><br>
                </div>
                <div class="col">
                    <label for="firstname">First name</label><br>
                    <input type="text" id="firstname" name="firstname" required><br><br>
                </div>
                <div class="col">
                    <label for="middlename">Middle name</label><br>
                    <input type="text" id="middlename" name="middlename" required><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="dateofbirth">Date of Birth</label><br>
                    <input type="date" id="dateofbirth" name="dateofbirth" required><br>
                </div>
                <div class="col">
                    <label for="age">Age</label><br>
                    <input type="number" id="age" name="age" min="1" max="99" required oninput="validateAge(this)"><br><br>
                </div>
            </div>
            <label for="placeofbirth">Place of Birth</label><br>
            <input type="text" id="placeofbirth" name="placeofbirth" required><br>
            <label for="address">Address</label><br>
            <input type="text" id="address" name="address" required><br>
            <label for="occupation">Occupation</label><br>
            <input type="text" id="occupation" name="occupation" required><br>
            <label for="parent">Parent/Guardian</label><br>
            <input type="text" id="parent" name="parent" required><br>
            <label for="contact">Contact</label><br>
            <input type="number" id="contact" name="contact" required><br>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" minlength="5" required><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password"  minlength="8" required><br>
            <label for="cpassword">Confirm Password</label><br>
            <input type="password" id="cpassword" name="cpassword"  minlength="8" required><br><br>

            <p id="error-message" style="color: red;"></p>

            <center>
                <p style="color: red; font-weight: bold;">Please upload any VALID ID for verification</p>
            </center>
            <label for="fileid">Select a file:</label>
            <input type="file" id="fileid" name="fileid" required><br><br>
            
            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" required>
            <label for="vehicle1"> I accept to the <a href="" data-bs-toggle="modal" data-bs-target="#termsConditions">terms and conditions</a></label><br><br>
            <center><input type="submit" value="Register" name ="register" onclick="validatePassword(event)"></center><br>
        </form>
        <center>
            <p>Already have an account? <a href="login.php">Click here to login!</a></p>
        </center>

        <div class="modal fade" id="termsConditions" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>Rural Health Unit (RHU) Appointment System</b><br>

                        Welcome to the RHU Appointment System. By accessing and using this system, you agree to comply with the following terms and conditions. If you do not agree, please refrain from using the system.

                        <ol>
                        <li>Purpose</li>

                        <ul><li>The RHU Appointment System is designed to facilitate online appointment scheduling for healthcare services provided by the Rural Health Unit. The system aims to reduce waiting times and improve service efficiency.</li></ul>

                        <li>User Eligibility</li>

                        <ul><li>Users must provide accurate and complete personal information when booking an appointment.</ul></li>

                        <ul><li>Only individuals seeking medical services from the RHU may use this system.</ul></li>

                        <li>Appointment Booking</li>

                        <ul><li>Appointments can be booked through the system based on available slots.</ul></li>

                        <ul><li>Users will receive an SMS notification confirming their appointment details.</ul></li>

                        <ul><li>Walk-in patients may also use the kiosk system to create an appointment based on availability.</ul></li>

                        <li>Appointment Cancellation and Rescheduling</li>

                        <ul><li>Users may cancel or reschedule their appointment at least 24 hours before the scheduled time through the system.</ul></li>

                        <ul><li>Failure to attend without cancellation may result in restrictions on future bookings.</ul></li>

                        <ul><li>The RHU reserves the right to cancel or reschedule appointments due to unforeseen circumstances, with prior notice to the user.</ul></li>

                        <li>User Responsibilities </li>

                        <ul><li>Users must arrive on time for their scheduled appointment and bring necessary documents (if required).</ul></li>

                        <ul><li>Any false or misleading information provided may result in the suspension of system access.</ul></li>

                        <ul><li> Users must respect healthcare personnel and other patients while using the RHU services.</ul></li>

                        <li>Privacy and Data Protection</li>

                        <ul><li>Personal information provided in the system will be used solely for appointment management and healthcare services.</ul></li>

                        <ul><li>The RHU ensures compliance with data privacy laws and will not share user data without consent, except as required by law.</ul></li>

                        <li>System Availability and Limitations</li>

                        <ul><li>The RHU strives to maintain system availability, but technical issues may occur.</ul></li>

                        <ul><li>The RHU is not responsible for any loss or inconvenience caused by system downtimes or appointment cancellations due to unforeseen events.</ul></li>

                        <li>Amendments to Terms</li>

                        <ul><li>The RHU reserves the right to update or modify these terms and conditions at any time.</ul></li>

                        <ul><li>Users will be notified of significant changes through the system or via SMS.</ul></li>

                        <li>Contact Information</li>

                        <ul><li>For inquiries, technical issues, or concerns regarding your appointment, please contact the RHU at [Contact Information].</ul></li>

                        <ul><li>By using the RHU Appointment System, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</ul></li>
                        </ol></p>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
    function validateAge(input) {
    if (input.value < 1) {
        input.value = 1;
    } else if (input.value > 99) {
        input.value = 99;
    }
}
function validatePassword(event) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("cpassword").value;
    let errorMessage = document.getElementById("error-message");

    if (password !== confirmPassword) {
        errorMessage.textContent = "Passwords do not match!";
        event.preventDefault(); // Prevent form submission
    } else {
        errorMessage.textContent = ""; // Clear error message
    }
}
</script>
</html>
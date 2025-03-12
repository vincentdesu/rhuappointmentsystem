<?php
require_once('get_available_slots.php');
require_once('functionskiosk.php');
$kiosk_functions->appoint();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rural Health Unit I Appointment System</title>
    <style>
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }
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
            position: absolute; /* Ensures the ::before pseudo-element is positioned relative to this */
            width: auto;
            height: auto; /* Full viewport height */
            background: url('bg.png') center/cover no-repeat; /* Example background */
        }


        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
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


        /* Style the form container */
        form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        /* Style labels */
        label {
            font-size: 1.2rem;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        /* Style the select and input elements */
        select,
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #2E7D32;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        /* Style for the textarea */
        textarea {
            resize: vertical;
            /* Allow the textarea to be resized vertically */
        }

        /* Style for the submit button */
        input[type="submit"] {
            padding: 15px 30px;
            font-size: 1.2rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #388E3C;
        }

        /* Style the available slots text */
        p {
            font-size: 1.1rem;
            color: #333;
        }

        /* Styling the heading with available slots */
        h1 {
            font-size: 2rem;
            color: #2E7D32;
            margin-bottom: 20px;
        }

        #reminder {
            background-color: white;
            /* White background */
            padding: 20px;
            max-width: 600px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Title style */
        #reminder h1 {
            color: black;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Paragraph text */
        #reminder p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 15px;
        }

        /* Style for the list items */
        #reminder li {
            font-size: 1rem;
            color: #333;
            margin-bottom: 10px;
            text-align: left;
        }

        /* Submit button styling */
        #reminder input[type="submit"] {
            padding: 12px 30px;
            font-size: 1.1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        #reminder input[type="submit"]:hover {
            background-color: #388E3C;
        }

        .hidden {
            display: none;
        }

        /* General reset and font settings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Style for the code container */
        #code {
            background-color: white;
            /* White background */
            padding: 30px;
            max-width: 600px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Title style */
        #code h1 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Highlighting the instruction */
        #code h1 div {
            color: red;
            font-weight: bolder;
        }

        /* Code section */
        #code h3 {
            font-size: 1.4rem;
            color: #555;
            margin-bottom: 10px;
        }

        /* Styling the code */
        #code h1:last-of-type {
            font-size: 3rem;
            font-weight: bold;
            color: #2E7D32;
            /* Green color for the code */
            margin-top: 10px;
        }

        /* Hidden class (for hiding the div initially) */
        .hidden {
            display: none;
        }

        /* Make sure the code block stands out */
        #code h1:last-of-type {
            border: 2px solid #2E7D32;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* Hover Effect */
        .btn:hover {
            background-color: #388E3C;
        }
        .getappointment{
            height: 95vh;
        }
        .getappointment {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .getappointment label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .getappointment select,
        .getappointment input,
        .getappointment textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .getappointment textarea {
            resize: none;
            height: 150px;
        }

        .getappointment button {

            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        .hidden {
            display: none;
        }


    </style>
</head>

<body>

    <div class="services">
        <h1>Get Appointment</h1>
        <div class ="getappointment" id = "info">
            <form action="" method="POST">
                <label for = "fullname">Full Name</label>
                <input type="text" name="fullname">
                <label for = "contact">Contact Number</label>
                <input type="number" name="contact"><br><br>
                <button type="button" class="btn" onclick="showgetAppoint()">Next</button>

        </div>
        <div class="hidden getappointment" id="getappointment">
                <label for="service">Choose a service:</label>
                <select id="service" name="service" required>
                    <option value="">-- Select Service --</option>
                    <option value="checkup">Check Up</option>
                    <option value="dentalcares">Dental Cares</option>
                    <option value="animalbites">Animal Bites</option>
                </select>
                <br><br>
                <label for="dateofschedule">Date of Schedule</label>
                <input type="date" id="dateofschedule" name="dateofschedule" required>
                <br><br>
                <label for="timeofschedule">Time of Schedule:</label>
                <select id="timeofschedule" name="timeofschedule" required>
                    <option value="">-- Select Time --</option>
                    <option value="9">9:00 AM</option>
                    <option value="10">10:00 AM</option>
                    <option value="11">11:00 AM</option>
                    <option value="2">2:00 PM</option>
                    <option value="3">3:00 PM</option>
                    <option value="4">4:00 PM</option>
                </select>
                <br><br>
                <p>Available slots:</p>
                <h1 id="availableSlots" style="color:black"></h1>

                <label for="message">Reason for Consulation</label><br>
                <textarea id="message" name="message" rows="10" cols="50" placeholder="Write your message here..."
                    required></textarea>
                <br><br>
                <button type="button" class="btn" onclick="showReminder()" id="nextButton">Next</button>

        </div>

        <div id="reminder" class="hidden getappointment">

            <h1 style="color: black;">Reminder</h1>
            <p>Appointment System is a way for patients to avail a schedule for their own. However please take of
                note
                of following:</p><br>

            <ol>
                <li>There are only limited schedule slots per day.</li>
                <li>Please take a screenshot or take a note for the code and input it in the KIOSK provided in the
                    facility</li>
                <li>Always follow the appointment schedule.</li>
            </ol>
<br><br><br><br>
            <button type="button" class="btn" onclick="showCode()">Next</button>

        </div>

        <div id="code" class="getappointment hidden">

            <h1>PLEASE <div style="color: red; font-weight: bolder;">TAKE A SCREENSHOT OR TAKE NOTE OF THIS CODE
                </div>
                WHICH IT WILL BE USED IN THE KIOSK IN THE FACILITY</h1>

            <h3>CODE</h3>
            <h1 id="randomCodeDisplay"></h1>
            <input type="hidden" id="randomCode" name="randomCode">
            <br><br><br><br>
            <input type="submit" value="Home" name="getappoint">
            </form>
        </div>
    </div>
    <footer>
        <div class="footer">
            <p>ALL RIGHTS RESERVED 2025</p>
        </div>
    </footer>
    <script>
        function generateRandomCode(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let code = '';
            for (let i = 0; i < length; i++) {
                code += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return code;
        }

        window.onload = function () {
            const code = generateRandomCode(10);
            document.getElementById('randomCodeDisplay').textContent = code;
            document.getElementById('randomCode').value = code;
            console.log("Generated Code:", code); // Debugging
        };

        document.querySelector("form").onsubmit = function () {
            console.log("Submitting Random Code:", document.getElementById("randomCode").value);
        };
        // JavaScript to handle the submit action and show the new div
        function showReminder() {
            document.getElementById("getappointment").classList.add("hidden");
            document.getElementById("reminder").classList.remove("hidden");

        }
        document.addEventListener("DOMContentLoaded", function () {
            checkSlots(); // Run when the page loads
        });
        function checkSlots() {
            let availableSlotsElement = document.getElementById("availableSlots");
            let nextButton = document.getElementById("nextButton");

            if (!availableSlotsElement) return; // Prevent errors if element is missing

            let availableSlots = availableSlotsElement.innerText.trim();

            if (availableSlots === "0" || availableSlots === "") {
                nextButton.disabled = true;  // Disable the button
                nextButton.style.backgroundColor = "gray"; // Change color to indicate disabled state
                nextButton.style.cursor = "not-allowed";  // Change cursor
            } else {
                nextButton.disabled = false; // Enable the button
                nextButton.style.backgroundColor = ""; // Reset color
                nextButton.style.cursor = "pointer";  // Reset cursor
            }
        }

        // Run checkSlots every time the available slots are updated
        setInterval(checkSlots, 500); // Check every 500ms (half a second)
        function showCode() {
            document.getElementById("reminder").classList.add("hidden");
            document.getElementById("code").classList.remove("hidden");
        }
        function showgetAppoint() {
            document.getElementById("info").classList.add("hidden");
            document.getElementById("getappointment").classList.remove("hidden");
        }

        let today = new Date();
        let maxDate = new Date();
        maxDate.setDate(today.getDate() + 30); // Add 30 days

        // Format dates to YYYY-MM-DD
        let todayFormatted = today.toISOString().split('T')[0];
        let maxDateFormatted = maxDate.toISOString().split('T')[0];

        // Set min and max attributes
        document.getElementById("dateofschedule").setAttribute("min", todayFormatted);
        document.getElementById("dateofschedule").setAttribute("max", maxDateFormatted);


        document.addEventListener("DOMContentLoaded", function () {
            let serviceSelect = document.getElementById("service");
            let dateInput = document.getElementById("dateofschedule");
            let timeSelect = document.getElementById("timeofschedule");
            let availableSlots = document.getElementById("availableSlots");

            // Event listeners for when any of the fields change
            serviceSelect.addEventListener("change", fetchAvailableSlots);
            dateInput.addEventListener("change", fetchAvailableSlots);
            timeSelect.addEventListener("change", fetchAvailableSlots);

            function fetchAvailableSlots() {
                let selectedService = serviceSelect.value;
                let selectedDate = dateInput.value;
                let selectedTime = timeSelect.value;

                if (selectedService && selectedDate && selectedTime) {
                    // Make an AJAX request to fetch available slots
                    fetch(`get_available_slots.php?service=${selectedService}&date=${selectedDate}&time=${selectedTime}`)
                        .then(response => response.json())
                        .then(data => {
                            // Update available slots display
                            availableSlots.textContent = data.slotCount; // Display number of available slots

                            // Update the available slot options (if needed)
                            // This part will depend on how you want to display the slots.
                        })
                        .catch(error => {
                            console.error("Error fetching available slots:", error);
                            availableSlots.textContent = "Error loading slots";
                        });
                }
            }
        });


    </script>

</body>

</html>
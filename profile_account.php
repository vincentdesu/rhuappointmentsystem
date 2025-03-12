<?php
require_once('functions.php');
$userdetails = $functions->get_userdata();
$userdata = $functions->get_userdata();
$functions->edit_profile();
$functions->change_password();
$status = $userdata['status'];
if (!isset($_SESSION['userdata']) || empty($_SESSION['userdata'])) {
    echo '<script>
        alert("Please login");
        window.location.href = "login.php";
    </script>';
    exit(); // Stop execution after redirect
}
$functions->edit_profile();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - RHU Appointment System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            text-align: center;
            background: url("bg.png") no-repeat center/cover;
            position: relative;
            min-height: 100vh; /* Ensures body takes full viewport height */
            overflow-x: hidden; /* Prevents horizontal scrolling */
        }

        body::before {
            content: "";
            position: fixed; /* Ensures it stays fixed even on scroll */
            top: 0;
            left: 0;
            width: 100vw; /* Covers full viewport width */
            height: 100vh; /* Covers full viewport height */
            background: rgba(46, 125, 50, 0.7); /* Green overlay */
            z-index: -1; /* Places it behind all content */
        }

        .header {
            background-color: #2E7D32;
            padding: 15px;
            color: white;
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
            flex-grow: 1;
            text-align: right;
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

        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
            animation: fadeIn 1.5s ease-in-out;
        }

        .profile-container h2 {
            color: #2E7D32;
            margin-bottom: 10px;
            text-align: center;
        }

        .profile-info {
            margin: 15px 0;
        }

        .profile-info strong {
            color: #388E3C;
        }

        .edit-profile-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
        }

        .edit-profile-btn:hover {
            transform: scale(1.05);
            background-color: #388E3C;
        }

        .footer {
            background-color: #2E7D32;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }


        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideRightToLeft {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
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
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>

    <div class="profile-container">
        <h2>My Profile</h2>
        <div class="profile-info"><strong>Username:</strong> <?php echo htmlspecialchars($userdetails['username']); ?></div>
        <div class="profile-info"><strong>Last Name:</strong> <?php echo htmlspecialchars($userdetails['lastname']); ?></div>
        <div class="profile-info"><strong>First Name:</strong> <?php echo htmlspecialchars($userdetails['firstname']); ?></div>
        <div class="profile-info"><strong>Middle Name:</strong> <?php echo htmlspecialchars($userdetails['middlename']); ?></div>
        <div class="profile-info"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($userdetails['dateofbirth']); ?></div>
        <div class="profile-info"><strong>Age:</strong> <?php echo htmlspecialchars($userdetails['age']); ?></div>
        <div class="profile-info"><strong>Place of Birth:</strong> <?php echo htmlspecialchars($userdetails['placeofbirth']); ?></div>
        <div class="profile-info"><strong>Address:</strong> <?php echo htmlspecialchars($userdetails['address']); ?></div>
        <div class="profile-info"><strong>Occupation:</strong> <?php echo htmlspecialchars($userdetails['occupation']); ?></div>
        <div class="profile-info"><strong>Parent:</strong> <?php echo htmlspecialchars($userdetails['parent']); ?></div>
        <div class="profile-info"><strong>Contact:</strong> <?php echo htmlspecialchars($userdetails['contact']); ?></div>

        <button type="button" class="edit-profile-btn btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            Edit Profile
        </button>
        <button type="button" class="edit-profile-btn btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
            Change Password
        </button>
    </div>
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm" action = "" method = "POST">
                        <input type="hidden" name="user_id" value="<?= $userdetails['id']; ?>">

                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($userdetails['username']); ?>" required>

                        <label for="lastname">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" value="<?= htmlspecialchars($userdetails['lastname']); ?>" required>

                        <label for="firstname">First Name:</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" value="<?= htmlspecialchars($userdetails['firstname']); ?>" required>

                        <label for="middlename">Middle Name:</label>
                        <input type="text" id="middlename" name="middlename" class="form-control" value="<?= htmlspecialchars($userdetails['middlename']); ?>" required>

                        <label for="dateofbirth">Date of Birth:</label>
                        <input type="date" id="dateofbirth" name="dateofbirth" class="form-control" value="<?= htmlspecialchars($userdetails['dateofbirth']); ?>" required>

                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" class="form-control" value="<?= htmlspecialchars($userdetails['age']); ?>" required>

                        <label for="placeofbirth">Place of Birth:</label>
                        <input type="text" id="placeofbirth" name="placeofbirth" class="form-control" value="<?= htmlspecialchars($userdetails['placeofbirth']); ?>" required>

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($userdetails['address']); ?>" required>

                        <label for="occupation">Occupation:</label>
                        <input type="text" id="occupation" name="occupation" class="form-control" value="<?= htmlspecialchars($userdetails['occupation']); ?>" required>

                        <label for="parent">Parent:</label>
                        <input type="text" id="parent" name="parent" class="form-control" value="<?= htmlspecialchars($userdetails['parent']); ?>" required>

                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" class="form-control" value="<?= htmlspecialchars($userdetails['contact']); ?>" required>

                        <button type="submit" class="btn btn-success w-100 mt-3" name = "submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm" action = "" method = "POST">
                        <input type="hidden" name="user_id" value="<?= $userdetails['id']; ?>">

                        <label for="current_password">Current Password:</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>

                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>

                        <button type="submit" class="btn btn-success w-100 mt-3" name = "change_password">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="footer">
            <p>ALL RIGHTS RESERVED 2025</p>
        </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>

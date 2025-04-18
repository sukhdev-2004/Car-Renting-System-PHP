<?php
    require "conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            flex: 1;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
            color: white;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="users_details.php">Users Details</a>
        <a href="car_details.php">Car Details</a>
        <a href="booking_details.php">Booking Details</a>
        <a href="contact_details.php">Contact Details</a>
    </div>

    <!-- Add your content here -->

</body>
</html>

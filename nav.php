<?php
require ("a1.html");
require ("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 10px 20px;
        }

        .logo a {
            color: white;
            text-decoration: none;
            font-size: 30px;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            margin-left: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #575757;
        }

        

        .btn {
            padding: 10px 20px;
            margin-left: 5px;
            border-radius: 3px;
            margin-right:120px;
            font-size:17px;
            border: none;
            background-color: #575757;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background-color: #444;
        }
        .ser{
            margin-right:170px;
        }
        a{
            font-size:18px;
        }
    </style>
    <link rel="shortcut icon" href="car_logo.jpg" type="image/x-icon">
  
</head>
<body>
    <!-- Modern Horizontal Navigation Bar with Dropdown -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="#">Car Rental</a>
            </div>
            <ul class="nav-links">
                
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Services</a>
                    <div class="dropdown-content">
                        <a href="rent.php">Rent My Car</a>
                    </div>
                </li>
                <li><a href="cart.php">Cart </a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>

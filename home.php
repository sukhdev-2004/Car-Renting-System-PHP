<?php
session_start();
require ("nav.php"); // Ensure this file correctly establishes a $conn connection
$user_id = $_SESSION['id'];
// Handle search
$search_results = [];
if (isset($_POST['search'])) {
    $search_word = mysqli_real_escape_string($conn, $_POST['t1']);
    $signle_char = $search_word[0];
    $search_results = mysqli_query($conn, "SELECT * FROM `car_rent` WHERE `car_brand` LIKE '$signle_char%' OR `car_brand` = '$search_word'");
} else {
    $search_results = mysqli_query($conn, "SELECT * FROM car_rent");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 1250px;
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .car-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            width:400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .car-card:hover {
            box-shadow: 0 0 10px black;
        }

        .car-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .car-card .details {
            padding: 15px;
        }

        .car-card .details h2 {
            margin: 0 0 10px;
            font-size: 1.5em;
            color: #333;
        }

        .car-card .details p {
            margin: 5px 0;
            color: #666;
        }

        .car-card .details .price {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
        }

        button {
            background-color: #333;
            color: #fff;
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            transition: 0.2s ease-in-out;
            border-radius: 20px;
        }

        button:hover {
            box-shadow: 0 0 10px black;
            transform: scale(1.1);
        }

        .search-bar {
            display: flex;
            width: 100%;
            border-radius: 50px;
            height: 60px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            margin-top: 10px;
            justify-content: center;
        }

        .search-bar input[type="text"] {
            padding: 5px;
            border-radius: 30px;
            border: 1px solid #ccc;
            padding-left: 10px;
            padding-right: 150px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .btn {
            border-radius: 30px;
            margin-left: 10px;
            box-shadow: 0 0 5px;
        }
    </style>
</head>
<body>
    <form method="post">
        <div class="search-bar">
            <input type="text" name="t1" placeholder="Search...">
            <button name="search" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    
    
    <?php if (isset($_POST['search'])) { ?>
        <div class="container">
            <h1>Search Results</h1>
            <div class="car-grid">
                <?php if (mysqli_num_rows($search_results) > 0) { ?>
                    <?php while($car = mysqli_fetch_assoc($search_results)) { ?>
                        <div class="car-card">
                            <img src="rent/<?php echo $car['image1']; ?>" alt="Car Image">
                            <div class="details">
                                <h2><?php echo $car['car_brand'] . " " . $car['car_model']; ?></h2>
                                <p><strong>Owner:</strong> <?php echo $car['owner_name']; ?></p>
                                <p><strong>Contact:</strong> <?php echo $car['contact']; ?></p>
                                <p><strong>Year:</strong> <?php echo $car['year_of_manufacture']; ?></p>
                                <p><strong>Color:</strong> <?php echo $car['color']; ?></p>
                                <p><strong>Mileage:</strong> <?php echo $car['mileage']; ?> km</p>
                                <p><strong>Description:</strong> <?php echo $car['description']; ?></p>
                                <p class="price">$<?php echo $car['price_per_day']; ?> per day</p>
                                <button type="submit" name="v_<?php echo $car['unique_id']; ?>">View Car</button>
                                <button type="submit" name="a_<?php echo $car['unique_id']; ?>">Add To Cart</button>
                                <?php
                                    if (isset($_POST["v_" . $car['unique_id']])) {
                                        $_SESSION['unique_id'] = $car['unique_id'];
                                        echo "<script>window.location.href='view_car.php';</script>";
                                    }
                                    if (isset($_POST["a_" . $car['unique_id']])) {

                                        $id1 = $car['unique_id'];
                                        $price = $car['price_per_day'];
                                        $p1 = $car['image1'];
                                        $brand = $car['car_brand'];
                                        $model =  $car['car_model'];
        
                                        $check = mysqli_query($conn,"SELECT * FROM `cart` WHERE `unique_id` = '$id1' AND `user_id` = '$user_id'");
                                        $tot_check = mysqli_num_rows($check);
                                        if($tot_check > 0){
                                            echo "<script>alert('Already Exist In Cart!');</script>";
                                        }
                                        else{
                                        $save_cart = mysqli_query($conn,"INSERT INTO `cart`(`unique_id`, `user_id`, `price`, `p1`, `brand`, `model`) VALUES ('$id1','$user_id','$price','$p1','$brand','$model')");
                                        
                                        if($save_cart){
                                            echo "<script>alert('Added To Cart');</script>";
                                        }
                                    }
                                    }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No results found.</p>
                <?php } ?>
            </div>
        </div>
    <?php }
    else {?>

    <div class="container">
        <h1>Available Cars for Rent</h1>
        <div class="car-grid">
            <?php while($car = mysqli_fetch_assoc($search_results)) { ?>
                <div class="car-card">
                    <img src="rent/<?php echo $car['image1']; ?>" alt="Car Image">
                    <div class="details">
                        <h2><?php echo $car['car_brand'] . " " . $car['car_model']; ?></h2>
                        <p><strong>Owner:</strong> <?php echo $car['owner_name']; ?></p>
                        <p><strong>Contact:</strong> <?php echo $car['contact']; ?></p>
                        <p><strong>Year:</strong> <?php echo $car['year_of_manufacture']; ?></p>
                        <p><strong>Color:</strong> <?php echo $car['color']; ?></p>
                        <p><strong>Mileage:</strong> <?php echo $car['mileage']; ?> km</p>
                        <p><strong>Description:</strong> <?php echo $car['description']; ?></p>
                        <p class="price">$<?php echo $car['price_per_day']; ?> per day</p>
                        <button type="submit" name="v_<?php echo $car['unique_id']; ?>">View Car</button>
                        <button type="submit" name="a_<?php echo $car['unique_id']; ?>">Add To Cart</button>
                        <?php
                            if (isset($_POST["v_" . $car['unique_id']])) {
                                $_SESSION['unique_id'] = $car['unique_id'];
                                echo "<script>window.location.href='view_car.php';</script>";
                            }
                            if (isset($_POST["a_" . $car['unique_id']])) {

                                $id1 = $car['unique_id'];
                                $price = $car['price_per_day'];
                                $p1 = $car['image1'];
                                $brand = $car['car_brand'];
                                $model =  $car['car_model'];

                                $check = mysqli_query($conn,"SELECT * FROM `cart` WHERE `unique_id` = '$id1' AND `user_id` = '$user_id'");
                                $tot_check = mysqli_num_rows($check);
                                if($tot_check > 0){
                                    echo "<script>alert('Already Exist In Cart!');</script>";
                                }
                                else{
                                $save_cart = mysqli_query($conn,"INSERT INTO `cart`(`unique_id`, `user_id`, `price`, `p1`, `brand`, `model`) VALUES ('$id1','$user_id','$price','$p1','$brand','$model')");
                                
                                if($save_cart){
                                    echo "<script>alert('Added To Cart');</script>";
                                }
                            }
                            }
                        ?>
                    </div>
                </div>
            <?php } 
            }?>
        </div>
    </div>
        </form>
</body>
</html>

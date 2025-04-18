<?php
session_start();
require("nav.php");
$unique_id = $_SESSION['unique_id'];
$user_id = $_SESSION['id'];
$car_result = mysqli_query($conn, "SELECT * FROM car_rent WHERE `unique_id` = '$unique_id'");
session_abort();


$car = mysqli_fetch_assoc($car_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .car-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .car-images {
            display: flex;
            overflow-x: scroll;
            margin-bottom: 20px;
            width: 80%;
            height:350px;
        }

        .car-images img {
            height: 350px;
            margin-right:30px;
            object-fit: cover;
            border: 1px solid #ccc;
            transition:0.2s ease-in-out;
        }

        .car-images::-webkit to-scrollbar {
            height: 10px;
        }

        .car-images::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .car-images::-webkit-scrollbar-thumb {
            background: #888;
        }

        .car-images::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .car-details .info {
            text-align: left;
            width: 100%;
        }

        .car-details .info p {
            margin: 10px 0;
            color: #666;
        }

        .car-details .info .price {
            font-size: 1.5em;
            color: #333;
            font-weight: bold;
        }
        img:hover{
            transition:0.2s ease-in-out;
            transform:scale(1.5);

        }
        .b1{
            margin-left:280px;
            border:none;
            padding:10px;
            background-color: #333;
            color: #fff;
            border-radius:5px;
            transition:0.2s ease-in-out;
            
        }
        .b1:hover{
            box-shadow: 0 0 10px black;
            transform:scale(1.1);
            }
            .b2{
            margin-left:10px;
            border:none;
            padding:10px;
            background-color: #333;
            color: #fff;
            border-radius:5px;
            transition:0.2s ease-in-out;
        }
        .b2:hover{
            box-shadow: 0 0 10px black;
            transform:scale(1.1);
            }
        
    </style>
</head>
<body>
    <form method="post">
    <div class="container">
        <h1><?php echo $car['car_brand'] . " " .$car['car_model'] ; ?></h1>
        <div class="car-details">
            <div class="car-images">
                <img src="rent/<?php echo $car['image1']; ?>" alt="Car Image 1">
                <img src="rent/<?php echo $car['image2']; ?>" alt="Car Image 2">
                <img src="rent/<?php echo $car['image3']; ?>" alt="Car Image 3">
                <img src="rent/<?php echo $car['image4']; ?>" alt="Car Image 4">
            </div>
            <div class="info">
                <p><strong>Owner:</strong> <?php echo $car['owner_name']; ?></p>
                <p><strong>Contact:</strong> <?php echo $car['contact']; ?></p>
                <p><strong>Email:</strong> <?php echo $car['email']; ?></p>
                <p><strong>Year:</strong> <?php echo $car['year_of_manufacture']; ?></p>
                <p><strong>Color:</strong> <?php echo $car['color']; ?></p>
                <p><strong>Mileage:</strong> <?php echo $car['mileage']; ?> km</p>
                <p><strong>Description:</strong> <?php echo $car['description']; ?></p>
                <p class="price">$<?php echo $car['price_per_day']; ?> per day</p>
            </div>  
         
        </div>
        <input type="submit" class="b1" value="Book Car" name="book"> <input class="b2" type="submit" name="cart" value="Add To Cart" name="cart ">
    </div>
    
    </form>
</body>
</html>
<?php
    if(isset($_POST["book"])){
        echo "<script>window.location.href='get_car.php';</script>";
        
    }
    if(isset($_POST["cart"])){
        $car_brand = $car['car_brand'];
        $car_model =  $car['car_model'];
        $car_price =  $car['price_per_day'];
        $img1 = $car['image1'];

        $check = mysqli_query($conn,"SELECT * FROM `cart` WHERE `unique_id` = '$unique_id' AND `user_id` = '$user_id'");
        $tot_check = mysqli_num_rows($check);
        if($tot_check > 0){
        echo "<script>alert('Already Exist In Cart!');</script>";
        }
        else{
        $store_cart = mysqli_query($conn,"INSERT INTO `cart`(`unique_id`, `user_id`, `price`, `p1`, `brand`, `model`) VALUES ('$unique_id','$user_id','$car_price','$img1','$car_brand','$car_model')");
        if($store_cart){
            echo "<script>alert('Added SuccessFully!');</script>";
        }
    }
       
    }
?>
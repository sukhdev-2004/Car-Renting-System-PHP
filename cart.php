<?php
session_start();
require("nav.php");
$user_id = $_SESSION['id'];


$cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
$tot_cart = mysqli_num_rows($cart);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 10px;
        }

        .cart-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            height: 390px;
            width: 300px;
            transition:0.2s ease-in-out;
        }
        .cart-card:hover{
            transition:0.2s ease-in-out;
            box-shadow: 0 0 10px #333;

        }

        .cart-card img {
            width: 100%;
            height: 200px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .cart-card-details {
            text-align: center;
        }

        .cart-card-details h3 {
            margin: 0;
            color: #333;
            font-size: 1em;
        }

        .cart-card-details p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9em;
        }

        .checkout-button {
            display: block;
            width: 100%;
            padding: 15px 0;
            margin-top: 20px;
            background-color: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .checkout-button:hover {
            background-color: #575757;
        }
        .btn1{
        background-color: #333;
            color: #fff;
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            transition: 0.2s ease-in-out;
            border-radius: 20px;
        }

        .btn1:hover {
            box-shadow: 0 0 10px black;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <form method="post">
    <div class="container">
        <h1>Your Cart</h1>
        
        <?php if ($tot_cart > 0) : ?>
            <div class="cart-grid">
                <?php while ($item = mysqli_fetch_assoc($cart)) : 
                    $car_id = $item['unique_id'];
                    $car_result = mysqli_query($conn, "SELECT * FROM car_rent WHERE unique_id = '$car_id'");
                    $car = mysqli_fetch_assoc($car_result);
                ?>
                    <div class="cart-card">
                        <img src="rent/<?php echo $item['p1']; ?>" alt="Car Image">
                        <div class="cart-card-details">
                            <h3><?php echo $item['brand'] . " " . $item['model']; ?></h3>
                            <p>Price Per Day: <?php echo $item['price'] . "$" ?></p><br><br>
                            <button class="btn1" name="r_<?php echo $item['unique_id'];?>" type="submit">Remove</button>
                            <button class="btn1" name="b_<?php echo $item['unique_id'];?>"  type="submit">Book Car</button>
                            <?php
                              if (isset($_POST["r_" . $item['unique_id']])){
                                $unique_1 = $item['unique_id'];
                                $remove = mysqli_query($conn,"DELETE FROM `cart` WHERE `unique_id` = '$unique_1'");
                                if($remove){
                                    // echo "<script>alert('Item Removed!');</script>";
                                    echo "<script>window.open('cart.php','_self');</script>";
                                    
                                }
                              }
                              if (isset($_POST["b_" . $item['unique_id']])){
                               $ii1 = $_SESSION['unique_id'] = $item['unique_id'];
                               echo "<script>window.open('view_car.php','_self');</script>";
                            //    session_abort();

                              }
                            ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p><h1>No Items In Your Cart.</h1</p>
        <?php endif; ?>
    </div>
        </form>
</body>
</html>

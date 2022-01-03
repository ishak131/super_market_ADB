<?php
include("../consolelog.php");
include("../connectedDB.php");
session_start();
try {
    if (isset($_GET['_id'])) {
        $recipt_id = mysqli_real_escape_string($connect, $_GET['_id']);
        $_SESSION['recipt_id'] = $recipt_id;
    }

    if (!isset($_SESSION['item'])) {
        $_SESSION['item'] = array();
    }
    $product_array = $_SESSION['item'];
    $recipt_id = $_SESSION['recipt_id'];

    if (isset($_GET['add_item'])) {
        $product_id = $_GET['product_id'];
        $product_quantity = $_GET['product_quantity'];
        if ($product_id && $product_quantity) {
            $query = "SELECT * FROM product_recipt WHERE product_id=$product_id AND recipt_id=$recipt_id";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $query = "SELECT quantityInMarket FROM product WHERE _id= $product_id";
                $result = $connect->query($query);
                $item = mysqli_fetch_assoc($result);

                if ($item['quantityInMarket'] < $product_quantity) {
                    $Error_massage = "There is less than you want";
                } else {
                    foreach ($product_array as $key => $value) {
                        if ($value['id'] == $product_id) {
                            $product_array[$key]['quantity'] = $product_quantity;
                            $product_array[$key]['total_price'] = $product_quantity * $value['price'];
                        }
                    }
                    $query = "UPDATE product_recipt SET quantity='$product_quantity' WHERE product_id=$product_id AND recipt_id=$recipt_id";
                    $connect->query($query);
                    $_SESSION['item'] = $product_array;
                }
            } else {
                $query = "SELECT p_name,price,unity,quantityInMarket,importPrice FROM product WHERE _id= $product_id";
                $result = $connect->query($query);
                if ($result->num_rows > 0) {
                    $product = mysqli_fetch_assoc($result);
                    if ($product['quantityInMarket'] < $product_quantity) {
                        $Error_massage = "There is less than you want";
                    } else {
                        $query = "INSERT INTO product_recipt (product_id,recipt_id,quantity) VALUES ('$product_id','$recipt_id','$product_quantity')";
                        $connect->query($query);
                        $arr['id'] = $product_id;
                        $arr['p_name'] = $product['p_name'];
                        $arr['price'] = $product['price'];
                        $arr['unity'] = $product['unity'];
                        $arr['importPrice'] = $product['importPrice'];
                        $arr['quantity'] = $product_quantity;
                        $arr['total_price'] = $product_quantity * $product['price'];
                        $arr['total_profits'] = $arr['total_price'] - ($product_quantity * $product['importPrice']);
                        $_SESSION['item'][count($product_array)] = $arr;
                        $product_array = $_SESSION['item'];
                    }
                } else {
                    console_log("Not Found");
                }
            }
        }
    }



    if (isset($_GET['remove'])) {
        $index = mysqli_real_escape_string($connect, $_GET['remove']);
        $product_id = $product_array[$index]['id'];
        $query = "DELETE FROM product_recipt WHERE product_id = $product_id AND recipt_id = $recipt_id";
        $connect->query($query);
        array_splice($product_array, $index, 1);
        $_SESSION['item'] = $product_array;
        header("location:create_sale_recipt.php");
    }
    $total_price = 0;
    $total_profits = 0;
    foreach ($product_array as $key => $value) {
        $total_price += $value['total_price'];
        $total_profits += $value['total_profits'];
    }

    if (isset($_GET['submit'])) {
        foreach ($product_array as $key => $value) {
            $sale = -1 * $value['quantity'];
            $query = "CALL update_quantity_in_market('$value[id]',' $sale')";
            $result = $connect->query($query);
        }
        $query = "UPDATE total_price_recipt SET total_price = '$total_price',total_profits='$total_profits' WHERE _id = '$recipt_id'";
        $res = $connect->query($query);
        header("location:new_sale_recipt.php?new=1");
    }
    $connect->close();
} catch (\Throwable $th) {
    $error = $th;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipt</title>
    <style>
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <form class='form' action="#" method="GET">
        product id : <input type="text" placeholder="product id" name="product_id">
        </br>
        </br>
        quantity : <input type="number" step=0.01 min=".01" placeholder="product quantity" name="product_quantity">
        <input type="submit" value="add_item" name="add_item">
        </br>
        </br>
        <table border="2px">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Unity</th>
                    <th>Total_pricr</th>
                    <th>remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product_array as $key => $value) : ?>
                    <tr>
                        <td><?php echo $value['p_name'] ?></td>
                        <td><?php echo $value['quantity'] ?></td>
                        <td><?php echo $value['price'] ?></td>
                        <td><?php echo $value['unity'] ?></td>
                        <td><?php echo $value['total_price'] ?></td>
                        <td>
                            <a href="?remove=<?php echo $key; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td>Total_pricr</td>
                    <td><?php echo $total_price; ?></td>
                </tr>
            </tbody>
        </table>
        <?php console_log($error); ?>
        <?php if ($Error_massage == "There is less than you want") : ?>
            <script>
                alert('There is less than you want');
            </script>
        <?php endif ?>
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>
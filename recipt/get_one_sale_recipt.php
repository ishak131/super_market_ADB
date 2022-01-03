<?php
include("../consolelog.php");
include("../connectedDB.php");



if (isset($_GET['id'])) {
    $_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM recipt WHERE _id = $_id";
    $result = $connect->query($query);
    $recipt = mysqli_fetch_assoc($result);

    $query = "SELECT * from product_recipt WHERE recipt_id = $_id";
    $x = $connect->query($query);
    foreach ($x as $key => $value) {
        $query = "SELECT p_name,price,unity FROM product WHERE _id = $value[product_id]";
        $result = $connect->query($query);
        $product_recipt[$key] = mysqli_fetch_assoc($result);
        $product_recipt[$key]["quantity"] = $value['quantity'];
        $product_recipt[$key]["total_price"] = $value['quantity'] * $product_recipt[$key]["price"];
    }

    $query = "SELECT total_price from total_price_recipt WHERE _id = $_id";
    $result = $connect->query($query);
    $total_price = mysqli_fetch_assoc($result);
}
$connect->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>recipt</title>
</head>

<body>
    <?php include("../teamplate/headers.php") ?>
    <div class="row">
        <div class='column'>
            <div class='card' style="width:fit-content; height: fit-content;">
                <h3> <?php echo "_id : " . $recipt['_id'] ?></h3>
                <h3> <?php echo "Date : " . $recipt['recipt_data'] ?></h3>
                <table border=".5px">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Unity</th>
                            <th>Total_pricr</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($product_recipt as $key => $value) : ?>
                            <tr>
                                <td><?php echo $value['p_name'] ?></td>
                                <td><?php echo $value['quantity'] ?></td>
                                <td><?php echo $value['price'] ?></td>
                                <td><?php echo $value['unity'] ?></td>
                                <td><?php echo $value['total_price'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <h3><?php echo "Total price : $total_price[total_price]" ?></h3>
            </div>
        </div>
    </div>
</body>

</html>
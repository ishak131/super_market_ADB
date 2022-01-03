<?php
include('../consolelog.php');
include('../connectedDB.php');
$quary = "SELECT * FROM product";
$resultAll = $connect->query($quary);
$connect->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>product</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <h2>All Product in Shop</h2>
    <div class="row">
        <?php foreach ($resultAll as $product) : ?>
            <div class='column'>
                <div class='card'>
                    <a style="color: black; text-decoration: none;" href="./get_one_product.php?id=<?php echo $product['_id'] ?>">
                        <h3> <?php echo "Name : " . $product['p_name'] ?></h3>
                        <p> <?php echo "Type :" . $product['p_type'] ?> </p>
                        <p> <?php echo "Quantity in Market :" . $product['quantityInMarket'] ?></p>
                        <p> <?php echo "Quantity in store :" . $product['quantityInStore'] ?></p>
                        <p> <?php echo "Price :" . $product['price'] ?></p>
                        <p> <?php echo "Export Price :" . $product['exportPrice'] ?></p>
                        <p> <?php echo "Import price :" . $product['importPrice'] ?></p>
                        <p> <?php echo "Unity :" . $product['unity'] ?></p>
                        <p> <?php echo "Pakageg Pecies :" . $product['PackagePecies'] ?></p>
                        <h3> <?php echo "id: " . $product['_id'] ?></h3>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
<?php
include("../consolelog.php");
include("../connectedDB.php");

if (isset($_GET['new'])) {
    $Query = "insert";
    $status_id = "text";
    $status_quantity = "hidden";
    $product_quantity_In_Market = 0;
    $product_quantity_In_Store = 0;
}
if (isset($_GET['id'])) {
    $Query = "update";
    $status_id = "hidden";
    $status_quantity = "number";
    $_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM product WHERE _id = $_id";
    $result = mysqli_query($connect, $query);
    $product = mysqli_fetch_assoc($result);
    $product_name = $product['p_name'];
    $product_type = $product['p_type'];
    $product_price = $product['price'];
    $product_export_price = $product['exportPrice'];
    $product_import_price = $product['importPrice'];
    $product_quantity_In_Market =  $product['quantityInMarket'];
    $product_quantity_In_Store = $product['quantityInStore'];
    $product_pakage_peacies = $product['PackagePecies'];
    $product_unity = $product['unity'];
    $product_suppliers = $product['supllier_id'];
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <form class='form' action="./insert_update_product.php" method="POST">
        <input type="<?php echo $status_id ?>" placeholder="product id" value="<?php echo $_id; ?>" name="product_id">
        <input type=" text" placeholder="product name" value="<?php echo $product_name; ?>" name="product_name">
        <input type="text" placeholder="product type" value="<?php echo $product_type; ?>" name="product_type">
        <input type="number" step=0.01 placeholder="product price" value="<?php echo $product_price ?>" name="product_price">
        <input type="<?php echo $status_quantity ?>" step=0.01 placeholder="quantity in market" value="<?php echo $product_quantity_In_Market; ?>" name="product_quantity_In_Market">
        <input type="<?php echo $status_quantity ?>" step=0.01 placeholder="quantity in store" value="<?php echo $product_quantity_In_Store; ?>" name="product_quantity_In_Store">
        <input type="number" step=0.01 placeholder="product export price" value="<?php echo $product_export_price ?>" name="product_export_price">
        <input type="number" step=0.01 placeholder="product import price" value="<?php echo $product_import_price ?>" name="product_import_price">
        <input type="number" step=0.01 placeholder="pakage peacies" value="<?php echo $product_pakage_peacies ?>" name="product_pakage_peacies">
        <input type="text" placeholder="unity" value="<?php echo $product_unity ?>" name="product_unity">
        <input type="text" placeholder="product suppliers" value="<?php echo $product_suppliers ?>" name="product_suppliers">
        <input type="submit" value="<?php echo $Query; ?>" name="<?php echo $Query; ?>">
    </form>
</body>

</html>
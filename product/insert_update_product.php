<?php
include('../consolelog.php');
include('../connectedDB.php');
$Requair = array();
try {

    foreach ($_POST as $key => $value) {
        if ((empty($value) && $value != 0))
            array_push($Requair, $key);
    }
    if (count($Requair) == 0) {
        console_log($_POST);
        $_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_type = $_POST['product_type'];
        $product_price = $_POST['product_price'];
        $product_export_price = $_POST['product_export_price'];
        $product_import_price = $_POST['product_import_price'];
        $product_quantity_In_Market = $_POST['product_quantity_In_Market'];
        $product_quantity_In_Store = $_POST['product_quantity_In_Store'];
        $product_suppliers = $_POST['product_suppliers'];
        $product_pakage_peacies = $_POST['product_pakage_peacies'];
        $product_unity = $_POST['product_unity'];
        $quary = "SELECT * FROM suppliers WHERE supllier_id = $product_suppliers";
        $result = $connect->query($quary);
        if ($result->num_rows == 0) {
            $suppliers_Not_Exist = true;
        } else {
            $suppliers_Not_Exist = false;
            if (isset($_POST['insert'])) {
                $quary = "SELECT * FROM product WHERE _id =$_id";
                $result = $connect->query($quary);
                if ($result->num_rows > 0) {
                    $product_exist = true;
                } else {
                    $Query = "insert";
                    $producr_exist = false;
                    $quary = "CALL insert_product('$_id','$product_name','$product_price','$product_type','$product_export_price','$product_import_price','$product_unity','$product_pakage_peacies','$product_suppliers');";
                }
            } elseif (isset($_POST['update'])) {
                $quary = "CALL update_product('$_id','$product_name','$product_price','$product_type','$product_quantity_In_Market','$product_quantity_In_Store','$product_export_price','$product_import_price','$product_unity','$product_pakage_peacies','$product_suppliers')";
            }
            $result = $connect->query($quary);
        }
    } else {
        $Requair_iteam = true;
    }
    $connect->close();
} catch (\Throwable $th) {
    $Requair_iteam = 1;
}

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
    <?php if ($Requair_iteam) : ?>
        <div class="alert">
            <strong>Warning!</strong>
            <?php foreach ($Requair as $value) : ?>
                <strong><?php echo $value; ?> is Requair </strong>
            <?php endforeach; ?>
        </div>
    <?php elseif ($product_exist) : ?>
        <div class="alert">
            <strong>Warning!</strong> Product already Exist
        </div>
    <?php else : ?>
        <?php if ($suppliers_Not_Exist) : ?>
            <div class="alert">
                <strong>Warning!</strong> Suppliers Not Exist .
            </div>
        <?php elseif ($result) : ?>
            <div class="alert success">
                <strong>Success!</strong>
            </div>
            <?php if ($Query == "insert") : ?>
                <button><a href=".//create_product.php?new=true" ?>create new product</a></button>
            <?php endif; ?>
            <button><a href="./get_one_product.php?id=<?php echo $_id; ?>">show Product</a></button>
        <?php else : ?>
            <div class="alert">
                <strong>Warning!</strong> Some Thing go wrong.
            </div>
        <?php endif ?>
    <?php endif ?>

</body>

</html>
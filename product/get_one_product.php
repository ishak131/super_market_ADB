<?php
include("../consolelog.php");
include("../connectedDB.php");

if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($connect, $_POST['id_to_delete']);
    $query = "DELETE FROM product WHERE _id = $id_to_delete";

    if (mysqli_query($connect, $query)) {
        header('Location: ./get_All_product.php');
    } else {

        echo 'query error: ' . mysqli_error($connect);
    }
}

if (isset($_POST['update'])) {
    $id_to_update = mysqli_real_escape_string($connect, $_POST['id_to_update']);
    header("Location: ./create_product.php?id=$id_to_update");
}



if (isset($_GET['id'])) {
    $_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM product WHERE _id = $_id";
    $result = $connect->query($query);
    $product = mysqli_fetch_assoc($result);
    $query = "SELECT * from suppliers WHERE supllier_id = $product[supllier_id]";
    $result = $connect->query($query);
    $suppliers = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
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
    <title>product</title>
</head>

<body>
    <?php include("../teamplate/headers.php") ?>
    <div class="row">
        <div class='column'>
            <div class='card'>
                <h3> <?php echo "Name : " . $product['p_name'] ?></h3>
                <p> <?php echo "Type :" . $product['p_type'] ?> </p>
                <p> <?php echo "Quantity in Market :" . $product['quantityInMarket'] ?></p>
                <p> <?php echo "Quantity in store :" . $product['quantityInStore'] ?></p>
                <p> <?php echo "Price :" . $product['price'] ?></p>
                <p> <?php echo "Export Price :" . $product['exportPrice'] ?></p>
                <p> <?php echo "Import price :" . $product['importPrice'] ?></p>
                <p> <?php echo "Unity :" . $product['unity'] ?></p>
                <p> <?php echo "Pakageg Pecies :" . $product['PackagePecies'] ?></p>
                <p> <?php echo "Suppliers Name : " . $suppliers['s_name'] ?></p>
                <p><?php echo "Suppliers Email : " . $suppliers['s_email']; ?></p>
                <h3> <?php echo "id: " . $product['_id'] ?></h3>
                <form action="#" method="POST">
                    <input type="hidden" name="id_to_delete" value="<?php echo $product['_id'] ?>">
                    <input type="submit" name="delete" value="Delete">
                    <input type="hidden" name="id_to_update" value="<?php echo $product['_id'] ?>">
                    <input type="submit" name="update" value="Update">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include("../consolelog.php");
include("../connectedDB.php");

if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($connect, $_POST['id_to_delete']);
    $query = "SELECT * from product WHERE supllier_id = $id_to_delete";
    $result = $connect->query($query);
    if ($result->num_rows > 0) {
        $error_Massage = true;
    } else {
        $query = "DELETE FROM suppliers WHERE supllier_id = $id_to_delete";
        $result = $connect->query($query);
        header('Location: ./get_All_product.php');
    }
}

if (isset($_POST['update'])) {
    $id_to_update = mysqli_real_escape_string($connect, $_POST['id_to_update']);
    header("Location: ./create_supplier.php?id=$id_to_update");
}



if (isset($_GET['id'])) {
    $_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM suppliers WHERE supllier_id = $_id";
    $result = mysqli_query($connect, $query);
    $supplier = mysqli_fetch_assoc($result);
    $query = "SELECT phone from supplier_phone WHERE _id = $_id";
    $supplier_phone = mysqli_query($connect, $query);
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
    <title>supplier</title>
</head>

<body>
    <?php include("../teamplate/headers.php") ?>
    <div class="row">
        <div class='column'>
            <div class='card'>
                <h3> <?php echo "Name : " . $supplier['s_name'] ?></h3>
                <p> <?php echo "Email :" . $supplier['s_email'] ?> </p>
                <?php foreach ($supplier_phone as $key => $value) : ?>
                    <p><?php echo 'Phone ' . ($key + 1) . ':' . $value['phone']; ?></p>
                <?php endforeach; ?>
                <h3> <?php echo "id: " . $supplier['supllier_id'] ?></h3>
                <form action="#" method="POST">
                    <input type="hidden" name="id_to_delete" value="<?php echo $supplier['supllier_id'] ?>">
                    <input type="submit" name="delete" value="Delete">
                    <input type="hidden" name="id_to_update" value="<?php echo $supplier['supllier_id'] ?>">
                    <input type="submit" name="update" value="Update">
                </form>
            </div>
        </div>
    </div>
    <?php if ($error_Massage == true) : ?>
        <div class="alert">
            <strong>Warning!</strong>can't delete this supplier
        </div>
    <?php endif ?>
</body>

</html>
<?php
include("../consolelog.php");
include("../connectedDB.php");


$supplier_phone = array('', '', '');

if (isset($_GET['new'])) {
    $Query = "insert";
    $status = "text";
}
if (isset($_GET['id'])) {
    $Query = "update";
    $status = "hidden";
    $_id = mysqli_real_escape_string($connect, $_GET['id']);
    $query = "SELECT * FROM suppliers WHERE supllier_id = $_id";
    $result = mysqli_query($connect, $query);
    $supplier = mysqli_fetch_assoc($result);
    $query = "SELECT phone from supplier_phone WHERE _id= $_id";
    $phone_table = mysqli_query($connect, $query);
    foreach ($phone_table as $key => $value) {
        console_log("Key : $key");
        console_log($value['phone']);
        $supplier_phone[$key] = $value['phone'];
    }
    $supplier_name = $supplier['s_name'];
    $supplier_email = $supplier['s_email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supplier</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <form class='form' action="./insert_update_supplier.php" method="POST">
        <input type="<?php echo $status ?>" placeholder="supplier id" value="<?php echo $_id; ?>" name="supllier_id">
        <input type=" text" placeholder="supplier name" value="<?php echo $supplier_name; ?>" name="s_name">
        <input type="email" placeholder="supplier email" value="<?php echo $supplier_email; ?>" name="s_email">
        <?php foreach ($supplier_phone as $key => $value) : ?>
            <input type="text" placeholder="supplier phone" value="<?php echo $value; ?>" name="s_phone[<?php echo $key ?>]">
        <?php endforeach ?>
        <input type="submit" value="<?php echo $Query; ?>" name="<?php echo $Query; ?>">
    </form>
</body>

</html>
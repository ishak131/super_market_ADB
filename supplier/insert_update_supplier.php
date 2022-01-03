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
        $supllier_id = ($_POST['supllier_id']);

        $supplier_name = ($_POST['s_name']);
        $supplier_email = ($_POST['s_email']);
        $supplier_phone = $_POST['s_phone'];
        if (isset($_POST['insert'])) {
            $quary = "SELECT * FROM suppliers WHERE supllier_id = $supllier_id";
            $result = $connect->query($quary);
            if ($result->num_rows > 0) {
                $supplier_exist = true;
            } else {
                $Query = "insert";
                $supplier_exist = false;
                $quary = "CALL insert_supplier('$supllier_id','$supplier_name','$supplier_email')";
                $result = $connect->query($quary);
                foreach ($supplier_phone as $key => $value) {
                    if ($value == '') continue;
                    $quary = "CALL insert_supplier_phone('$supllier_id','$value')";
                    $connect->query($quary);
                }
            }
        } elseif (isset($_POST['update'])) {
            $query = "SELECT phone from supplier_phone WHERE _id = $supllier_id";
            $supplier_Old_phone = mysqli_query($connect, $query);
            $quary = "CALL update_supplier('$supllier_id','$supplier_name','$supplier_email')";
            $result = $connect->query($quary);
            $lastKey = $supplier_Old_phone->num_rows;
            foreach ($supplier_Old_phone as $key => $value) {
                $quary = "CALL update_supplier_phone('$supllier_id','$value[phone]','$supplier_phone[$key]');";
                $result = $connect->query($quary);
            }
            console_log($supplier_Old_phone->num_rows);
            while ($lastKey < count($supplier_phone)) {
                if ($supplier_phone[$lastKey] == '') {
                    $lastKey++;
                    continue;
                }
                $quary = "CALL insert_supplier_phone('$supllier_id','$supplier_phone[$lastKey]')";
                $connect->query($quary);
                $lastKey++;
            }
        }
    } else {
        $Requair_iteam = true;
    }
    $connect->close();
} catch (\Throwable $th) {
}
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
    <?php include('../teamplate/headers.php'); ?>
    <?php if ($Requair_iteam) : ?>
        <div class="alert">
            <strong>Warning!</strong>
            <?php foreach ($Requair as $value) : ?>
                <strong><?php echo $value; ?> is Requair </strong>
            <?php endforeach; ?>
        </div>
    <?php elseif ($$supplier_exist) : ?>
        <div class="alert">
            <strong>Warning!</strong> supplier already Exist
        </div>
    <?php else : ?>
        <?php if ($result) : ?>
            <div class="alert success">
                <strong>Success!</strong>
            </div>
            <?php if ($Query == "insert") : ?>
                <button><a href="./create_supplier.php" ?>create new supplier</a></button>
            <?php endif; ?>
            <button><a href="./get_one_supplier.php?id=<?php echo $supllier_id; ?>">show supplier</a></button>
        <?php else : ?>
            <div class="alert">
                <strong>Warning!</strong> Some Thing go wrong.
            </div>
        <?php endif ?>
    <?php endif ?>

</body>

</html>
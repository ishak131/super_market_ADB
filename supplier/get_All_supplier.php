<?php
include('../consolelog.php');
include('../connectedDB.php');
$quary = "SELECT * FROM suppliers";
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
    <title>supplier</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <h2>All suppliers</h2>
    <div class="row">
        <?php foreach ($resultAll as $supplier) : ?>
            <div class='column'>
                <div class='card'>
                    <a style="color: black; text-decoration: none;" href="./get_one_supplier.php?id=<?php echo $supplier['supllier_id'] ?>">
                        <h3> <?php echo "Name : " . $supplier['s_name'] ?></h3>
                        <p> <?php echo "Email :" . $supplier['s_email'] ?> </p>
                        <h3> <?php echo "id: " . $supplier['supllier_id'] ?></h3>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
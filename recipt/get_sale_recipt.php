<?php
include('../consolelog.php');
include('../connectedDB.php');
$query = "SELECT * from total_price_recipt WHERE total_price = 0";
$result = $connect->query($query);
foreach ($result as $key => $value) {
    $query = "CALL delete_all_recipt($value[_id]);";
    $connect->query($query);
}
$quary = "SELECT * FROM total_price_recipt WHERE r_Type = 'sales'";
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
    <title>recipt</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <h2>All sales recipt</h2>
    <div class="row">
        <?php foreach ($resultAll as $recipt) : ?>
            <div class='column'>
                <div class='card'>
                    <a style="color: black; text-decoration: none;" href="./get_one_sale_recipt.php?id=<?php echo $recipt['_id'] ?>">
                        <h3> <?php echo "total price : " . $recipt['total_price'] ?></h3>
                        <h3> <?php echo "id: " . $recipt['_id'] ?></h3>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
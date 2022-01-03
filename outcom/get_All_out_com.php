<?php
include('../consolelog.php');
include('../connectedDB.php');

$quary = "SELECT * FROM outCome";
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
    <title>out come</title>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <h2>All sales out come</h2>
    <div class="row">
        <?php foreach ($resultAll as $outcome) : ?>
            <div class='column'>
                <div class='card'>
                    <h3><?php echo "purchases : " . $outcome['purchases'] ?></h3>
                    <h3><?php echo "Sales : " . $outcome['sales'] ?></h3>
                    <h3><?php echo "total out come : " . $outcome['total_profits'];  ?></h3>
                    <h3><?php echo "MONTH: " . $outcome['outcome_month'] ?></h3>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if ($resultAll->num_rows == 0) {
            echo "<h3>you should first make a recipt</h3>";
        } ?>
    </div>
</body>

</html>
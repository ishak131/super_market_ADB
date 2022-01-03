<?php
include("../consolelog.php");
include("../connectedDB.php");
session_start();
try {


    if (!isset($_SESSION['item'])) {
        $_SESSION['item'] = array();
    }
    if (!$_SESSION['product']) {
        $_SESSION['product'] = array();
    }

    $item_array = $_SESSION['item'];
    $product_array = $_SESSION['product'];
    $recipt_id = $_SESSION['recipt_id'];
    $supllier_id = $_SESSION['suplier_id'];

    if (isset($_GET['_id'])) {
        $recipt_id = mysqli_real_escape_string($connect, $_GET['_id']);
        console_log($recipt_id);
        $_SESSION['recipt_id'] = $recipt_id;
    }

    if (isset($_GET['go'])) {
        unset($_SESSION['product']);
        $s_id = $_GET['supllier_id'];
        if ($s_id) {
            $_SESSION['suplier_id'] = $s_id;
            $supllier_id = $s_id;
            $query = "SELECT * from suppliers WHERE supllier_id = $s_id";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                $query = "SELECT _id,p_name,importPrice,unity FROM product WHERE supllier_id = $s_id";
                $result = $connect->query($query);
                $fix_arr;
                foreach ($result as $key => $value) {
                    $fix_arr['_id'] = $value['_id'];
                    $fix_arr['p_name'] = $value['p_name'];
                    $fix_arr['importPrice'] = $value['importPrice'];
                    $fix_arr['unity'] = $value['unity'];
                    $fix_arr['supllier'] = $s_id;
                    $_SESSION['product'][$value['_id']] = $fix_arr;
                    $fix_arr = array();
                }
                $product_array = $_SESSION['product'];
            } else {
                $Error_massage = "You should create supplier first";
            }
        }
    }

    if (isset($_GET['add_item'])) {
        $product_id = $_GET['product_id'];
        $product_quantity = $_GET['product_quantity'];
        if ($product_id && $product_quantity) {
            $query = "SELECT * FROM product_recipt WHERE product_id=$product_id AND recipt_id=$recipt_id";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                foreach ($item_array as $key => $value) {
                    console_log($key);
                    console_log($value);
                    if ($value['id'] == $product_id) {
                        $item_array[$key]['quantity'] = $product_quantity;
                        $item_array[$key]['total_price'] = $product_quantity * $value['importPrice'];
                    }
                }
                $query = "UPDATE product_recipt SET quantity='$product_quantity' WHERE product_id=$product_id AND recipt_id=$recipt_id";
                $connect->query($query);
                $_SESSION['item'] = $item_array;
            } else {

                $query = "INSERT INTO product_recipt (product_id,recipt_id,quantity) VALUES('$product_id','$recipt_id','$product_quantity')";
                $connect->query($query);

                $arr['supllier_id'] = $supllier_id;
                $arr['id'] = $product_id;
                $arr['p_name'] = $product_array[$product_id]['p_name'];
                $arr['importPrice'] = $product_array[$product_id]['importPrice'];
                $arr['unity'] = $product_array[$product_id]['unity'];
                $arr['quantity'] = $product_quantity;
                $arr['total_price'] = $product_quantity * $product_array[$product_id]['importPrice'];
                $_SESSION['item'][count($item_array)] = $arr;
                $item_array = $_SESSION['item'];
            }
        }
    }



    if (isset($_GET['remove'])) {
        $index = mysqli_real_escape_string($connect, $_GET['remove']);
        $product_id = $item_array[$index]['id'];
        $query = "DELETE FROM product_recipt WHERE product_id = $product_id AND recipt_id = $recipt_id";
        $connect->query($query);
        array_splice($item_array, $index, 1);
        $_SESSION['item'] = $item_array;
        header("location:create_purchase_recipt.php");
    }

    $total_price = 0;
    foreach ($item_array as $key => $value) {
        $total_price += $value['total_price'];
    }

    if (isset($_GET['submit'])) {
        foreach ($item_array as $key => $value) {
            $query = "CALL update_quantity_in_market('$value[id]','$value[quantity]')";
            $result = $connect->query($query);
        }
        $query = "UPDATE total_price_recipt SET total_price = '$total_price' WHERE _id = '$recipt_id'";
        console_log($query);
        $res = $connect->query($query);
        
        header("location:new_purchase_recipt.php?new=1");
    }
    $connect->close();
} catch (\Throwable $th) {
    echo "<script type='text/javascript'>alert(You enter some thing wrong);</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipt</title>
    <style>
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <?php include('../teamplate/headers.php'); ?>
    <form class='form' action="#" method="GET">
        <input type="text" value="<?php echo $supllier_id; ?>" placeholder="supplier_id" name="supllier_id">
        <input type="submit" value="go" name="go">
        </br>
        </br>
        product Name :
        <select name="product_id">
            <?php foreach ($product_array as $key => $value) : ?>
                <?php console_log($key);
                console_log($value); ?>
                <option value="<?php echo $value['_id'] ?>"><?php echo $value['p_name']; ?></option>
            <?php endforeach ?>
        </select>
        </br>
        </br>
        Product quantity : <input type="number" step=0.01 min=".01" placeholder="product quantity" name="product_quantity">
        <input type="submit" value="add_item" name="add_item">
        <br>
        <br>
        <table border="2px">
            <thead>
                <tr>
                    <th>supplier_id</th>
                    <th>product id</th>
                    <th>name</th>
                    <th>unity</th>
                    <th>import price</th>
                    <th>quantity</th>
                    <th>total price</th>
                    <th>remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item_array as $key => $value) : ?>
                    <tr>
                        <td><?php echo $value['supllier_id'] ?></td>
                        <td><?php echo $value['id'] ?></td>
                        <td><?php echo $value['p_name'] ?></td>
                        <td><?php echo $value['unity'] ?></td>
                        <td><?php echo $value['importPrice'] ?></td>
                        <td><?php echo $value['quantity'] ?></td>
                        <td><?php echo $value['total_price'] ?></td>
                        <td>
                            <a href="?remove=<?php echo $key; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td>Total_pricr</td>
                    <td><?php echo $total_price; ?></td>
                </tr>
            </tbody>
        </table>
        <?php console_log($Error_massage); ?>
        <?php if ($Error_massage == "There is less than you want") : ?>
            <script>
                alert('There is less than you want');
            </script>
        <?php endif ?>
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>
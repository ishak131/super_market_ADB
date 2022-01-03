<?php
include('../consolelog.php');
include('../connectedDB.php');
if (isset($_GET['new'])) {
    session_start();
    $query = "SELECT * from total_price_recipt WHERE total_price = 0";
    $result = $connect->query($query);
    foreach ($result as $key => $value) {
        $query = "CALL delete_all_recipt($value[_id]);";
        $connect->query($query);
    }
    $_SESSION['item'] = array();
    $query = "SELECT * FROM recipt";
    $result = $connect->query($query);
    $recipt_id = $result->num_rows + 123456789;
    $query = "INSERT INTO recipt(_id,discount) VALUES('$recipt_id','0')";
    $result = $connect->query($query);
    $query = "INSERT INTO total_price_recipt VALUES('$recipt_id','0','0','sales')";
    $connect->query($query);
    header("location:create_sale_recipt.php?_id=$recipt_id");
}

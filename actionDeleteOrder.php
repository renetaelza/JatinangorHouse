<?php

include 'server/connection.php';

$order_id = $_GET['order_id'];

$query = "DELETE FROM order_item WHERE order_id = '$order_id'";
mysqli_query($conn, $query);

$query2 = "DELETE FROM orders WHERE order_id = '$order_id'";
mysqli_query($conn, $query2);

header("location: account.php");
die();
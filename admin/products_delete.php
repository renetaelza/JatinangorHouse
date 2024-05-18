<?php
    ob_start();
    session_start();
    include('layouts/header.php');

    if (!isset($_SESSION['admin_logged_in'])) {
        header('location: login.php');
    }
?>

<?php

include 'server/connection.php';

$id = $_GET['product_id'];

$query = "DELETE FROM products WHERE product_id = '$id'";
mysqli_query($conn, $query);

header('location: products.php');
die();
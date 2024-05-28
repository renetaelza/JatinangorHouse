<?php
    /*
    Status:
    Not Paid
    Paid
    Shipped
    Delivered
    */
    include('server/connection.php');

    if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];

        $query_order_details = "SELECT * FROM order_item WHERE order_id = ?";

        $stmt_order_details = $conn->prepare($query_order_details);
        $stmt_order_details->bind_param('i', $order_id);
        $stmt_order_details->execute();
        $order_details = $stmt_order_details->get_result();

        $order_total_price = calculateTotalOrderPrice($order_details);
    } else {
        header('location: account.php');
        exit;
    }

    function calculateTotalOrderPrice($order_details) {
        $total = 0;

        foreach($order_details as $row) {
           $product_price = $row['product_price'];
           $product_quantity = $row['product_quantity'];

           $total = $total + ($product_price * $product_quantity);
        }

        return $total;
    }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jatinangor House</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<?php
    include('layouts/header.php');
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container text-center">
            <div class="border border-info" style="border-radius: 30px; width: 1130px; padding: 20px; border-width: 5px;text-align: left;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__text">
                            <h4>Detail Pesanan</h4>
                            <div class="breadcrumb__links">
                                <a href="./index.php">Home</a>
                                <a href="">></a>
                                <a href="./account.php">Account</a>
                                <a href="">></a>
                                <span>Detail Pesanan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Order Details Section Begin -->
    <section id="orders" class="shopping-cart spad" style="margin-top: -90px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Detail Pesanan</h2>
                        <br>
                    </div>
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Pesanan</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Tanggal Pesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order_details as $row) { ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="img/product/<?php echo $row['product_image']; ?>" alt="">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?php echo $row['product_name']; ?></h6>
                                                <h5><?php echo number_format($row['product_price'], 0, ',', '.'); ?></h5>
                                            </div>
                                        </td>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5><?php echo $row['product_quantity']; ?></h5>
                                            </div>
                                        </td>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5><?php echo number_format($row['product_quantity'] * $row['product_price'], 0, ',', '.'); ?></h5>
                                            </div>
                                        </td>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__text">
                                                <h5><?php echo $row['order_date']; ?></h5>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($order_status == 'not paid') { ?>
                            <form method="POST" action="payment.php">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="order_total_price" 
                                value="<?php echo $order_total_price; ?>" />
                                <input type="hidden" name="order_status" 
                                value="<?php echo $order_status; ?>" />
                                <div class="row">
                                    <div class="container text-center">
                                        <input style="background-color: #3AD4D5;" type="submit" name="order_pay_btn" class="btn btn-primary" value="Bayar Sekarang" />
                                        <a class="btn btn-danger" href="actionDeleteOrder.php?order_id=<?php echo $row['order_id']; ?>" onclick="return confirm('Are you sure to delete this data?')">Batalkan Pesanan</a>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                        <?php if ($order_status == 'paid') { ?>
                            <form method="POST" action="payment.php">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="order_total_price" 
                                value="<?php echo $order_total_price; ?>" />
                                <input type="hidden" name="order_status" 
                                value="<?php echo $order_status; ?>" />
                                <div class="row">
                                    <div class="container text-center">
                                        <a class="btn btn-danger" href="actionDeleteOrder.php?order_id=<?php echo $row['order_id']; ?>" onclick="return confirm('Apakah anda yakin untuk membatalkan pesanan?')">Batalkan Pesanan</a>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                        <?php if ($order_status != 'not paid' && $order_status != 'paid') { ?>
                            <form method="POST" action="payment.php">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                                <input type="hidden" name="order_total_price" 
                                value="<?php echo $order_total_price; ?>" />
                                <input type="hidden" name="order_status" 
                                value="<?php echo $order_status; ?>" />
                                <div class="row">
                                    <div class="container text-center">
                                        <a class="btn btn-info" style="background-color: #3AD4D5;" href="struk.php?order_id=<?php echo $row['order_id']; ?>">Cetak Struk</a>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container text-center" style="margin-top: 30px; margin-bottom: -50px;">
            <a href="account.php" style="color: black;">
                <img style="width: 20px;" src="img/icon/back.png" alt="">
                Kembali
            </a>
        </div>
    </section>
    <!-- Order Details Section End -->

    <?php 
    include ('layouts/footer.php'); 
    ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
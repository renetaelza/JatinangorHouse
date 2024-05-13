<?php
session_start();
if (!empty($_SESSION['cart'])) {
    // Let user in
} else {
    // Send user to hompe page
    // Kalau mau dihilangkan tinggal diberi comment
    //header('location: index.php');
}
?>

<?php
    include('layouts/header.php');
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container text-center">
            <div class="border border-info" style="border-radius: 30px; width: 1130px; text-align: left; padding: 20px; border-width: 5px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="index.php">Home</a>
                            <a href="">></a>
                            <a href="shop.php">Menu</a>
                            <a href="">></a>
                            <a href="shopping-cart.php">Shopping Cart</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad" style="margin-top: -90px;">
        <div class="container d-flex justify-content-center align-items-center" >
            <div class="checkout__form">
                <form id="checkout-form" method="POST" action="server/place_order.php">
                    <div style="width: 750px;" class="alert alert-danger" role="alert">
                        <?php if (isset($_GET['message'])) {
                            echo $_GET['message'];
                        } ?>
                        <?php if (isset($_GET['message'])) { ?>
                            <a href="login.php" class="btn btn-primary" style="margin-left: 10px;">Login</a>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="checkout__order" style="width: 750px;">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Price</span></div>
                                <ul class="checkout__total__products">
                                    <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                        <li><?php echo $value['product_quantity']; ?> <?php echo $value['product_name']; ?> <span> <?php echo $value['product_price']; ?></span></li>
                                    <?php } ?>
                                </ul>
                                <span class="checkout__order__products">Ongkos Kirim <span>20000</span></span>
                                <ul class="checkout__total__all" style="margin-top: 30px;">
                                    <li>Total <span><?php echo $_SESSION['total'] + 20000; ?></span></li>
                                </ul>

                                <input type="submit" style="background-color: #3AD4D5; margin:5px; padding: 10px 287px 10px" class="btn btn-info" id="checkout-btn" name="place_order" value="PLACE ORDER" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

<?php
    include('layouts/footer.php');
?>
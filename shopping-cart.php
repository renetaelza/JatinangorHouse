<?php
session_start();
if (isset($_POST['add_to_cart'])) {
    // If user has already add product to the cart
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        // If product has already added to cart or not
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image']
            );

            $_SESSION['cart'][$product_id] = $product_array;

            // Product has already been added
        } else {
            echo '<script>alert("Product was already added to the cart")</script>';
        }

        // If user the first add product to the cart
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image
        );

        $_SESSION['cart'][$product_id] = $product_array;
    }

    // Calculate total
    calculateTotalCart();

    // Remove product from the cart
} else if (isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];

    unset($_SESSION['cart'][$product_id]);

    // Calculate total
    calculateTotalCart();

    // Codingan baru
} else {
    //header('location: index.php');
}

function calculateTotalCart()
{
    $total_price = 0;
    $total_quantity = 0;

    foreach ($_SESSION['cart'] as $key => $value) {
        // Ambil quantity dari inputan user
        $quantity = isset($_POST['product_quantity'][$value['product_id']]) ? $_POST['product_quantity'][$value['product_id']] : $value['product_quantity'];

        // Pastikan quantity tidak kurang dari 1
        $quantity = max(1, $quantity);

        // Update quantity pada produk
        $_SESSION['cart'][$key]['product_quantity'] = $quantity;

        $price = $value['product_price'];

        // Hitung total harga dan total kuantitas
        $total_price += $price * $quantity;
        $total_quantity += $quantity;
    }

    // Simpan total harga dan total kuantitas ke dalam session
    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
}


?>
<?php
    include('layouts/header.php');
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="index.php">Home</a>
                            <a href="shop.php">Menu</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION['cart'])) { ?>
                                    <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                        <tr>
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="img/product/<?php echo $value['product_image']; ?>" alt="">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6><?php echo $value['product_name']; ?></h6>
                                                    <h5><?php echo $value['product_price']; ?></h5>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity">
                                                    <form method="POST" action="shopping-cart.php">
                                                        <div>
                                                            <input type="hidden" name="product_quantity[<?php echo $value['product_id']; ?>]" value="<?php echo $value['product_quantity']; ?>">
                                                            <input id="product_quantity_<?php echo $value['product_id']; ?>" type="number" name="product_quantity" value="<?php echo max(1, $value['product_quantity']); ?>" min="1">
                                                            <div>
                                                                <button class="editbtn" type="submit" name="edit_quantity"> Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        <td class="cart__price">
                                            <span id="product_price_<?php echo $value['product_id']; ?>"><?php echo $value['product_price']; ?></span>
                                        </td>
                                            <form method="POST" action="shopping-cart.php">
                                                <td>
                                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>">
                                                    <button type="submit" class="btn btn-danger" name="remove_product"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </form>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <div class="form-group row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Catatan (Opsional)</label>
                                                    <div class="col-sm-9">
                                                    <input type="text" class="form-control" placeholder="Contoh: sambalnya banyakin dong!">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="shop.php" class="btn btn-primary">Continue Shopping <i class="fa fa-arrow-circle-o-right fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Kode Promo</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Total <span><?php if(isset($_SESSION['cart'])) { echo $_SESSION['total']; } ?></span></li>
                        </ul>
                        <form method="POST" action="checkout.php">
                            <input type="submit" class="primary-btn" value="Checkout" name="checkout">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
    
    <body>
        <script>
            function calculatePrice(productId) {
                // Mendapatkan nilai quantity
                var quantity = document.getElementById('product_quantity_' + productId).value;
                
                // Mendapatkan harga produk
                var price = <?php echo $value['product_price']; ?>;
                
                // Menghitung total harga dan menampilkan pada span
                document.getElementById('product_price_' + productId).innerText = quantity * price;
            }
        </script>
    </body>
<?php
    include('layouts/footer.php');
?>
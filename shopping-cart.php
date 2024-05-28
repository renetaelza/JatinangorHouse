<?php
session_start();

function calculateTotalWithShipping()
{
    $total_with_shipping = 0;

    // Check if cart is not empty
    if (isset($_SESSION['cart'])) {
        // Calculate total price of all products in cart
        $total_price = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total_price += $item['product_price'] * $item['product_quantity'];
        }

        // Add flat shipping cost
        $total_with_shipping = $total_price + 20000;
    }

    return $total_with_shipping;
}

if (isset($_POST['add_to_cart'])) {
    // If user has already added product to the cart
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        // If product has already added to cart or not
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
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
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity
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

// Check if user pressed "edit_quantity" button
if (isset($_POST['edit_quantity'])) {
    // Get the product ID and new quantity from the form submission
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['product_quantity'];

    // Update the quantity of the product in the session cart
    $_SESSION['cart'][$product_id]['product_quantity'] = $new_quantity;

    // Recalculate total cart
    calculateTotalCart();
}

if(isset($_POST['notes'])){
    // Ambil nilai catatan dari inputan user
    $notes = $_POST['notes'];
    // Simpan catatan ke dalam session
    $_SESSION['notes'] = $notes;
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
    <div class="container text-center">
        <div class="border border-info" style="border-radius: 30px; width: 1130px; text-align: left; padding: 20px; border-width: 5px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="index.php">Home</a>
                            <a href="">></a>
                            <a href="shop.php">Menu</a>
                            <a href="">></a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad" style="margin-top: -100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th style="margin-left: 20px;">Quantity</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_SESSION['cart'])) { ?>
                                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                    <div>
                                        <tr>
                                            <td class="product__cart__item">
                                                <div class="product__cart__item__pic">
                                                    <img src="img/product/<?php echo $value['product_image']; ?>" alt="">
                                                </div>
                                                <div class="product__cart__item__text">
                                                    <h6><?php echo $value['product_name']; ?></h6>
                                                    <h5><?php echo number_format($value['product_price'], 0, ',', '.'); ?></h5>
                                                </div>
                                            </td>
                                            <td class="quantity__item">
                                                <div class="quantity" style="margin-left: 20px; display: flex; align-items: center;">
                                                    <form method="POST" action="shopping-cart.php" style="display: flex;">
                                                        <div>
                                                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                                            <input style="margin-top: 13px; margin-right: 15px;" type="number" name="product_quantity" value="<?php echo max(1, $value['product_quantity']); ?>" min="1" style="margin-right: 5px;">
                                                        </div>
                                                        <div>
                                                            <button class="editbtn" type="submit" name="edit_quantity"><i class="fa fa-refresh"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="cart__price">
                                                <span id="product_price_<?php echo $value['product_id']; ?>"><?php echo number_format($value['product_quantity'] * $value['product_price'], 0, ',', '.'); ?></span>
                                            </td>
                                            <form method="POST" action="shopping-cart.php">
                                                <td>
                                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>">
                                                    <button type="submit" class="btn btn-danger" name="remove_product"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </form>
                                        </tr>
                                        </tr>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <table>
                        <form id="notes_form" method="POST" action="shopping-cart.php">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Catatan (Opsional)</label>
                                <div class="col-sm-9">
                                    <input type="text" id="notes" name="notes" class="form-control" placeholder="Contoh: sambalnya banyakin dong!">
                                </div>
                            </div>
                        </form>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="shop.php" style="background-color: #3AD4D5; margin:5px; padding: 10px 80px 10px;" class="btn btn-info">Continue Shopping <i class="fa fa-arrow-circle-o-right fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h6 style="margin-left: 30px;margin-bottom: 20px; font-size: 20px; font-weight: 800;">Ringkasan Pembayaran</h6>
                <div class="cart__total">
                    <ul>
                        <li>Harga <span><?php if (isset($_SESSION['cart'])) {
                                                echo number_format($_SESSION['total'], 0, ',', '.');
                                            } ?></span></li>
                        <li style="border-bottom: 1px solid #000;">Ongkos Kirim <span>20.000</span></li>
                        <li style="margin-top: 20px; font-weight: 1000;">Total Pembayaran <span id="total_payment"><?php echo number_format(calculateTotalWithShipping(), 0, ',', '.'); ?></span></li>
                    </ul>
                    <form id="checkout_form" method="POST" action="checkout.php">
                        <input style="background-color: #3AD4D5; margin:5px; padding: 10px 80px 10px;" type="submit" class="btn btn-info" value="Checkout" name="checkout">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

<body>
    <script>
        const checkoutForm = document.getElementById('checkout_form');
        const notesInput = document.getElementById('notes');

        // Tambahkan event listener untuk saat tombol checkout ditekan
        checkoutForm.addEventListener('submit', function(event) {
            // Ambil nilai catatan
            const notes = notesInput.value;

            // Tambahkan nilai catatan sebagai parameter pada URL saat redirect ke halaman checkout
            checkoutForm.action = 'checkout.php?notes=' + encodeURIComponent(notes);
        });

        function calculatePrice(productId) {
            // Mendapatkan nilai quantity
            var quantity = document.getElementById('product_quantity_' + productId).value;

            // Mendapatkan harga produk
            var price = <?php echo $value['product_price']; ?>;

            // Menghitung total harga dan menampilkan pada span
            document.getElementById('product_price_' + productId).innerText = quantity * price;

            // Update total pembayaran
            updateTotalPayment();
        }

        function updateTotalPayment() {
            var total_payment = 0;
            var prices = document.querySelectorAll('[id^="product_price_"]');
            prices.forEach(function(element) {
                total_payment += parseInt(element.innerText);
            });
            total_payment += 20000; // Add shipping cost
            document.getElementById('total_payment').innerText = total_payment;
        }
    </script>
</body>
<?php
include('layouts/footer.php');
?>
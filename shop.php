<?php
    include('server/connection.php');

    $items_per_page = 9;

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($current_page - 1) * $items_per_page;

    $sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
    $sort_order = strtoupper($sort_order);
    if ($sort_order != 'ASC' && $sort_order != 'DESC') {
        $sort_order = 'ASC'; 
    }

    if (isset($_POST['search']) && isset($_POST['product_category'])) {
        $category = $_POST['product_category'];
        $query_products = "SELECT * FROM products WHERE product_category = ? LIMIT $offset, $items_per_page";
        $stmt_products = $conn->prepare($query_products);
        $stmt_products->bind_param('s', $category);
        $stmt_products->execute();
        $products = $stmt_products->get_result();
    } else {
        $query_products = "SELECT * FROM products LIMIT $offset, $items_per_page";
        $stmt_products = $conn->prepare($query_products);
        $stmt_products->execute();
        $products = $stmt_products->get_result();
    }

    $total_products_query = "SELECT COUNT(*) as total FROM products";
    $total_products_result = $conn->query($total_products_query);
    $total_products = $total_products_result->fetch_assoc()['total'];
    $total_pages = ceil($total_products / $items_per_page);
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
                        <h4>Menu</h4>
                        <div class="breadcrumb__links">
                            <a href="index.php">Home</a>
                            <span>Menu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search...">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <form method="POST" action="shop.php">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-heading">
                                            <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="shop__sidebar__categories">
                                                    <ul class="nice-scroll">
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Paket" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Paket') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Paket</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Burger" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Burger') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Burger</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Ala Carte" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Ala Carte') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Ala Carte</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Snack" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Snack') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Snack</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Drinks Coffee" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Drinks Coffee') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Coffee</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Drinks Non Coffee" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Drinks Non Coffee') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Non Coffee</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="Drinks Refreshing" 
                                                                    name="product_category" id="category_one " 
                                                                    <?php if (isset($product_category) && $product_category == 'Drinks Refreshing') 
                                                                    { 
                                                                        echo 'checked'; 
                                                                    } ?>>
                                                                <label class="form-check-label" for="product_category">Refreshing</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-secondary" onClick="history.go(0);">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <input type="submit" class="btn btn-primary" name="search" value="Search" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shop__product__option__left">
                                <p>Showing <?php echo $offset + 1; ?>–<?php echo min($offset + $items_per_page, $total_products); ?> of <?php echo $total_products; ?> results</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shop__product__option__right">
                                <p>Sort by Price:</p>
                                    <select onchange="location = this.value;">
                                        <option value="shop.php?sort=ASC" <?php if ($sort_order == 'ASC') echo 'selected'; ?>>Low To High</option>
                                        <option value="shop.php?sort=DESC" <?php if ($sort_order == 'DESC') echo 'selected'; ?>>High To Low</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php while ($row = $products->fetch_assoc()) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" 
                                data-setbg="img/product/<?php echo $row['product_image']; ?>">
                                </div>
                                <div class="product__item__text">
                                    <h6><?php echo $row['product_name']; ?></h6>
                                    <p><?php echo $row['product_description'] ?></p>
                                    <h5><?php echo $row['product_price']; ?></h5>
                                    <!-- Change the form action to shopping-cart.php -->
                                    <form method="POST" action="shopping-cart.php">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
                                        <!-- <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="number" name="product_quantity" value="1">
                                            </div>
                                        </div> -->
                                        <button style="background-color: #3AD4D5; margin:5px" type="submit" name="add_to_cart" class="btn btn-info">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <a <?php if ($i == $current_page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

<?php
    include('layouts/footer.php');
?>
<?php
    include('server/connection.php');

    $items_per_page = 12;

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $offset = ($current_page - 1) * $items_per_page;

    $sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
    $sort_order = strtoupper($sort_order);
    if ($sort_order != 'ASC' && $sort_order != 'DESC') {
        $sort_order = 'ASC'; 
    }

    if (isset($_GET['category'])) {
                $category = $_GET['category'];
                if ($category === 'All') {
                    $query_products = "SELECT * FROM products LIMIT $offset, $items_per_page";
                } else {
                    $query_products = "SELECT * FROM products WHERE product_category = ? LIMIT $offset, $items_per_page";
                }
                $stmt_products = $conn->prepare($query_products);
                if ($category !== 'All') {
                    $stmt_products->bind_param('s', $category);
                }
                $stmt_products->execute();
                $products = $stmt_products->get_result();
    } else if(isset($_POST['cari'])){
        $keyword = ucfirst(strtolower($_POST['keyword']));
        $q = "SELECT * FROM products WHERE product_name LIKE '%$keyword%' OR
              product_category LIKE '%$keyword%'";
        $stmt_products = $conn->prepare($q);
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
        <div class="container text-center">
            <div class="border border-info" style="border-radius: 30px; width: 1150px; padding: 20px; border-width: 5px; text-align: left;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb__text">
                            <h4>Menu</h4>
                            <div class="breadcrumb__links">
                                <a href="index.php">Home</a>
                                <a href="">></a>
                                <span>Menu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad" style="margin-top: -80px;">
    
        <div class="container">
            <div class="row">
                <details class="details-dropdown" style="margin-left: 30px; ">
                    <summary role="button">
                        <a style="font-weight: 600;" class="button">Kategori</a>
                    </summary>
                    <ul>
                        <form method="POST" action="shop.php">
                        <li><a href="?category=All">All</a></li>
                        <li><a href="?category=Paket">Paket</a></li>
                        <li><a href="?category=Burger">Burger</a></li>
                        <li><a href="?category=Ala Carte">Ala Carte</a></li>
                        <li><a href="?category=Snack">Snack</a></li>
                        <li><a href="?category=Drinks Coffee">Drinks Coffee</a></li>
                        <li><a href="?category=Drinks Non Coffee">Drinks Non Coffee</a></li>
                        <li><a href="?category=Drinks Refreshing">Drinks Refreshing</a></li>
                        </form>
                    </ul>
                </details>
                <div style="margin-left: 6px; width: 982px;" class="shop__sidebar__search">
                    <form action="shop.php" method="POST">
                        <input type="text" name="keyword" placeholder="Search">
                        <button class="btn btn-info" style="background-color: #3AD4D5;" type="submit" name="cari"><img src="img/icon/search.png"  style="width: 12px;" alt=""></button>
                    </form>
                </div>
            </div>
            
                <div class="col-lg-12">
                    <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shop__product__option__left">
                                <p>Showing <?php echo $offset + 1; ?>–<?php echo min($offset + $items_per_page, $total_products); ?> of <?php echo $total_products; ?> results</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php while ($row = $products->fetch_assoc()) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
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
                                        <input type="hidden" name="product_quantity" value="1">
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
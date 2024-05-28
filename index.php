<?php
    include('server/controller_favourite_product.php');
    include('layouts/header.php');
?>
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="img/hero/pictures1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Diskon 10%!</h6>
                                <h2>Bundling Signature Jhouse</h2>
                                <p>Nasi + ayam spicy dada/paha atas + scramble egg + kailan crispy + minuman pilihan.</p>
                                <a href="shop.php" class="primary-btn">Pesan Sekarang<span class="arrow_right"></span></a>
                                <div class="hero__social">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="img/hero/pictures2.png">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>NEWEST MENU</h6>
                                <h2>Spicy Chicken Burger</h2>
                                <p>Spicy Chicken Strips, Purple Cabbage, Pickle, and Cheese Sauce</p>
                                <a href="shop.php" class="primary-btn">Pesan Sekarang <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Latest Promo Section Begin -->
    <!-- <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 style="font-weight: 1000;">Promo Menarik</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/promo1.png"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt="">Berlaku hingga 26 April 2024</span>
                            <h5>Blue Lagoon Siganature</h5>
                            <span>Dapatkan diskon hingga 30%</span>
                            <a href="promo.php">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/promo2.png"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt="">Berlaku hingga 30 Mei 2024</span>
                            <h5>Creamy Mouthfeel</h5>
                            <span>Perpaduan Istimewa Kopi dan Susu</span>
                            <a href="promo.php">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/promo3.png"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt="">Berlaku hingga 15 Mei 2024</span>
                            <h5>Sebox Lebih Hemat</h5>
                            <span>Promo hingga 20 ribu</span>
                            <a href="promo.php">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="container text-center">
                    <a href="promo.php" class="primary-btn" style="margin-bottom: 50px;">Lihat Semua Promo</a>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Latest Promo Section End -->

    <!-- Product Section Begin -->
    <div class="latar" style="margin-bottom: -18px;">
        <section class="product spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2 style="font-weight: 1000;">Menu Favorit</h2>
                        </div>
                    </div>
                </div>
                <div class="row product__filter">
                    <?php while($row = $fav_products->fetch_assoc()) { ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" 
                            data-setbg="img/product/<?php echo $row['product_image']; ?>">
                            </div>
                            <div class="product__item__text">
                                <h6><?php echo $row['product_name']; ?></h6>
                                <p><?php echo $row['product_description'] ?></p>
                                <h5><?php echo number_format($row['product_price'], 0, ',', '.'); ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <div class="container text-center">
                <a href="shop.php" class="primary-btn" style="margin-bottom: 30px;">Lihat Semua Menu</a>
        </div>
    </div>
    <!-- Product Section End -->

    <!-- Slider Begin -->
    <div class="slider" style="margin: -18px;">
        <div class="slide-track">
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 1 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 2 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 1 Medium.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 2 Medium.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 1 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 2 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 1 Medium.jpg"class="imgslide"></div>

                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 2 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 1 Medium.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 2 Medium.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 1 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 2 Large.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Spicy JH Signature 1 Medium.jpg"class="imgslide"></div>
                <div class="slide"><img src="img/product/bundling signature/Paket Original JH Signature 1 Large.jpg"class="imgslide"></div>
        </div>
    </div>
    <!-- Slider End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>JH Bandung <br /> <span>JH Tangerang</span> <br /> JH Surabaya</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="img/banner/pic1.png" alt="" style="border-radius: 10px;">
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <br><br><br><br>
                        <span>NEWEST STORE</span>
                        <h2>Promo Opening 20%</h2>
                        <a href="about.php" class="primary-btn" style="background: black;">Visit Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig1.png"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig2.png"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig3.png"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig4.png"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig5.png"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/ig6.png"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Kunjungi instagram kami untuk mendapatkan info dan promo Jatinangor House.</p>
                        <div>
                            <a href="https://www.instagram.com/jatinangorhouse/" class="primary-btn" style="margin-bottom: 10px;">Instagram</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

<?php 
    include ('layouts/footer.php'); 
?>
<?php
    include('server/connection.php');

    $query_blogs = "SELECT * FROM blogs ORDER BY blog_id";

    $stmt_blogs = $conn->prepare($query_blogs);

    $stmt_blogs->execute();

    $blogs = $stmt_blogs->get_result();
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
                                        <h4>Promo</h4>
                                        <div class="breadcrumb__links">
                                            <a href="index.php">Home</a>
                                            <a href="">></a>
                                            <span>Promo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
        
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <?php foreach($blogs as $blog) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="<?php echo 'img/blog/'.$blog['blog_image']; ?>"></div>
                            <div class="blog__item__text">
                                <span><i class="fas fa-calendar-alt"></i> <?php echo date('d F Y', strtotime($blog['blog_date'])); ?></span>
                                <h5><?php echo $blog['blog_title']; ?></h5>
                                <a href="<?php echo "blog-details.php?blog_id=" . $blog['blog_id']; ?>">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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
    </div>

<?php
    include('layouts/footer.php');
?>
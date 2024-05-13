<?php
    include('layouts/header.php');
?>

    <section class="breadcrumb-option">
        <div class="container text-center">
            <div class="border border-info" style="border-radius: 30px; width: 1150px; text-align: left; padding: 20px; border-width: 5px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="breadcrumb__text">
                                    <h4>Contact</h4>
                                    <div class="breadcrumb__links">
                                        <a href="index.php">Home</a>
                                        <a href="">></a>
                                        <span>Contact</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        
    </section>

    <!-- Contact Section Begin -->
    <section class="contact spad" style="margin-top: -90px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__text">
                        <div class="section-title">
                            <h2>Kepuasan Anda selalu menjadi prioritas kami</h2>
                            <p>Untuk pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami menggunakan formulir di bawah ini. Kami akan menghubungi Anda sesegera mungkin.</p>
                        </div>
                        <div>
                                <div class="contact__form">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input type="text" placeholder="Name">
                                            </div>
                                            <div class="col-lg-5">
                                                <input type="text" placeholder="Email">
                                            </div>
                                            <div class="col-lg-10">
                                                <textarea placeholder="Message"></textarea>
                                                <button style="background-color: #24BBCB;" type="submit" class="site-btn">Send Message</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <img src="img/contact.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

<?php
    include('layouts/footer.php');
?>
<?php
    session_start();
    include('server/connection.php');

    if (isset($_SESSION['logged_in'])) {
        header('location: account.php');
        exit;
    }

    if (isset($_POST['login_btn'])) {
        $email = $_POST['user_email'];
        $password = md5($_POST['user_password']);

        $query = "SELECT user_id, user_name, user_email, user_password, user_phone, user_address, user_city, user_photo FROM users WHERE user_email = ? AND user_password = ? LIMIT 1";

        $stmt_login = $conn->prepare($query);
        $stmt_login->bind_param('ss', $email, $password);
        
        if ($stmt_login->execute()) {
            $stmt_login->bind_result($user_id, $user_name, $user_email, $user_password, $user_phone, $user_address, $user_city, $user_photo);
            $stmt_login->store_result();

            if ($stmt_login->num_rows() == 1) {
                $stmt_login->fetch();

                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_phone'] = $user_phone;
                $_SESSION['user_address'] = $user_address;
                $_SESSION['user_city'] = $user_city;
                $_SESSION['user_photo'] = $user_photo;
                $_SESSION['logged_in'] = true;

                header('location: account.php?message=Berhasil login!');
            } else {
                header('location: login.php?error=Email atau password salah!');
            }
        } else {
            // Error
            header('location: login.php?error=Something went wrong!');
        }
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
                            <h4>Login</h4>
                            <div class="breadcrumb__links">
                                <a href="index.php">Home</a>
                                <a href="">></a>
                                <span>Login</span>
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
        <div class="container d-flex justify-content-center align-items-center">
            <div class="checkout__form" style="width: 1000px;">
                <form id="login-form" method="POST" action="login.php">
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php if (isset($_GET['error'])) {
                                echo $_GET['error'];
                            } ?>
                        </div>
                    <?php } ?>
                    <div class>
                        <div class="col-lg-12 col-md-9">
                            <div class="checkout__input" style="border-radius: 10px;">
                                <p>Email</p>
                                <input type="email" name="user_email">
                            </div>
                            <div class="checkout__input" style="border-radius: 10px;">
                                <p>Password</p>
                                <input type="password" name="user_password">
                            </div>
                            <div class="checkout__input">
                                <input type="submit" style="color: white; border-radius: 10px;" class="btn btn-info" id="login-btn" name="login_btn" value="LOGIN" />
                            </div>
                            <div class="checkout__input__checkbox">
                                <label>
                                    <a id="register-url" href="register.php">Belum mempunyai akun? Daftar disini</a>
                                </label>
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
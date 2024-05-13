<?php
    session_start();
    include('server/connection.php');

    if (isset($_SESSION['logged_in'])) {
        header('location: account.php');
        exit;
    }

    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];

        // This is image file
        $photo = $_FILES['photo']['tmp_name'];

        // Photo name
        $photo_name = str_replace(' ', '_', $name) . ".jpg";

        // Upload image
        move_uploaded_file($photo, "img/profile/" . $photo_name);

        // If password didn't match
        if ($password !== $confirm_password) {
            header('location: register.php?error=Password did not match');

        // If password less than 6 characters
        } else if (strlen($password) < 6) {
            header('location: register.php?error=Password must be at least 6 characters');

        // Inf no error
        } else {
            // Check whether there is a user with this email or not
            $query_check_user = "SELECT COUNT(*) FROM users WHERE user_email = ?";

            $stmt_check_user = $conn->prepare($query_check_user);
            $stmt_check_user->bind_param('s', $email);
            $stmt_check_user->execute();
            $stmt_check_user->bind_result($num_rows);
            $stmt_check_user->store_result();
            $stmt_check_user->fetch();

            // If there is a user registered with this email
            if ($num_rows !== 0) {
                header('location: register.php?error=User with this email already exists');
            
            // If no user registered with this email
            } else {
                $query_save_user = "INSERT INTO users (user_name, user_email, user_password, user_phone, user_address, user_city, user_photo) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                // Create a new user
                $stmt_save_user = $conn->prepare($query_save_user);
                $stmt_save_user->bind_param('sssssss', $name, $email, md5($password), $phone, $address, $city, $photo_name);
                
                // If account was created successfully
                if ($stmt_save_user->execute()) {
                    $user_id = $stmt_save_user->insert_id;

                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_phone'] = $phone;
                    $_SESSION['user_address'] = $address;
                    $_SESSION['user_city'] = $city;
                    $_SESSION['user_photo'] = $photo_name;
                    $_SESSION['logged_in'] = true;
                    
                    header('location: account.php?register_success=You registered successfully!');
                // If account couldn't registered
                } else {
                    header('location: register.php?error=Could not create an account at the moment');
                }
            }
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
                            <h4>Registrasi</h4>
                            <div class="breadcrumb__links">
                                <a href="index.php">Home</a>
                                <a href="">></a>
                                <a href="login.php">Login</a>
                                <a href="">></a>
                                <span>Registrasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Register Section Begin -->
    <section class="checkout spad" style="margin-top: -90px;">
        <div class="container">
            <div class="checkout__form">
                <form id="checkout-form" method="POST" action="register.php" enctype="multipart/form-data">
                    <div class="alert alert-danger" role="alert">
                        <?php if (isset($_GET['error'])) {
                            echo $_GET['error'];
                        } ?>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <h6 class="checkout__title">REGISTRASI</h6>
                            <div class="checkout__input">
                                <p>Nama<span>*</span></p>
                                <input type="text" id="registered-name" name="name" required>
                            </div>
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input id="registered-email" type="email" name="email" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Password<span>*</span></p>
                                        <input id="registered-password" type="password" name="password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Confirm Password<span>*</span></p>
                                        <input id="registered-confirm-password" type="password" name="confirm_password">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Nomor Telepon<span>*</span></p>
                                <input type="text" name="phone" required>
                            </div>
                            <div class="checkout__input">
                                <p>Kota<span>*</span></p>
                                <input type="text" name="city" required>
                            </div>
                            <div class="checkout__input">
                                <p>Alamat<span>*</span></p>
                                <input type="text" name="address" placeholder="Street Address" class="checkout__input__add" required>
                            </div>
                            <div>
                                <p>Foto Profil (Opsional)<span></span></p>
                                <div class="custom-file">
                                    <input type="file" id="photo" name="photo" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="cold-md-12">
                                    <p> </p>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <input type="submit" style="color: white; border-radius: 10px;" class="btn btn-info" id="register-btn" name="register" value="REGISTER" />
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="acc">
                                    <a style="margin-left: -30px;" id="login-url" href="login.php">Sudah mempunyai akun? Login disini</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Register Section End -->

<?php
    include('layouts/footer.php');
?>
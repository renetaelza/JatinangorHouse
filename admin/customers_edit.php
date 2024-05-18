<?php
    ob_start();
    session_start();
    include('layouts/header.php');

    if (!isset($_SESSION['admin_logged_in'])) {
        header('location: login.php');
    }
?>

<?php 
    if (isset($_GET['users_id'])) {
        $users_id = $_GET['users_id'];
        $query_edit_product = "SELECT * FROM users WHERE users_id = ?";
        $stmt_edit_product = $conn->prepare($query_edit_product);
        $stmt_edit_product->bind_param('i', $users_id);
        $stmt_edit_product->execute();
        $users = $stmt_edit_product->get_result();

    } else if (isset($_POST['edit_btn'])) {
        $id = $_POST['users_id'];
        $name = $_POST['users_name'];
        $category = $_POST['users_category'];
        $description = $_POST['users_description'];
        $criteria = $_POST['users_criteria'];
        $price = $_POST['users_price'];

        $query_update_product = "UPDATE users SET users_name = ?, users_category = ?, users_description = ?, users_criteria = ?, users_price = ? 
            WHERE users_id = ?";

        $stmt_update_product = $conn->prepare($query_update_product);
        $stmt_update_product->bind_param('ssssdi', $name, $category, $description, $criteria, $price, $id);

        if ($stmt_update_product->execute()) {
            header('location: customers.php?success_update_message=Product has been updated successfully');
        } else {
            header('location: customers.php?fail_update_message=Error occured, try again!');
        }
    } else {
        header('location: customers.php');
        exit;
    }
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Customers</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="customers.php">Customer</a></li>
            <li class="breadcrumb-item active">Edit Customer</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Customer</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form id="edit-form" method="POST" action="customers_edit.php">
                        <div class="row">
                            <?php foreach ($users as $customer) { ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="hidden" name="users_id" value="<?php echo $customer['users_id']; ?>" />
                                        <label>Name of Customer</label>
                                        <input class="form-control" type="text" name="users_name" value="<?php echo $customer['users_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="users_category">
                                            <option value="" disabled>Select Category</option>
                                            <option value="Paket" <?php if ($customer['users_category'] == 'Paket') echo ' selected'; ?>>Paket</option>
                                            <option value="Burger" <?php if ($customer['users_category'] == 'Burger') echo ' selected'; ?>>Burger</option>
                                            <option value="Snack" <?php if ($customer['users_category'] == 'Snack') echo ' selected'; ?>>Snack</option>
                                            <option value="Ala Carte" <?php if ($customer['users_category'] == 'Ala Carte') echo ' selected'; ?>>Ala Carte</option>
                                            <option value="Drinks Refreshing" <?php if ($customer['users_category'] == 'Drinks Refreshing') echo ' selected'; ?>>Drinks Refreshing</option>
                                            <option value="Drinks Coffee" <?php if ($customer['users_category'] == 'Drinks Coffee') echo ' selected'; ?>>Drinks Coffee</option>
                                            <option value="Drinks Non Coffee" <?php if ($customer['users_category'] == 'Drinks Non Coffee') echo ' selected'; ?>>Drinks Non Coffee</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="5" name="users_description"><?php echo $customer['users_description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Criteria</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="favourite" name="users_criteria" value="favourite" required <?php if ($customer['users_criteria'] == 'favourite') echo ' checked'; ?>>
                                            <label class="custom-control-label" for="favourite">Favourite</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="none" name="users_criteria" value="none" required <?php if ($customer['users_criteria'] == 'none') echo ' checked'; ?>>
                                            <label class="custom-control-label" for="none">None</label>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label>Price</label>
                                        <input class="form-control" type="text" name="users_price" value="<?php echo $customer['users_price']; ?>">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="m-t-20 text-right">
                            <a href="products.php" class="btn btn-outline-danger">Cancel <i class="fas fa-undo"></i></a>
                            <button type="submit" class="btn btn-outline-success submit-btn" name="edit_btn">Update <i class="fas fa-share-square"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>
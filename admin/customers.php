<?php
session_start();
include('layouts/header.php'); 

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}
?>

<?php
    $query_users = "SELECT * FROM users";

    $stmt_users = $conn->prepare($query_users);
    $stmt_users->execute();
    $users = $stmt_users->get_result();
?>

<!-- Begin Page Content -->
<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 text-uppercase fw-bolder">Customers</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Customers</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (isset($_GET['success_update_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_update_message'])) {
                        echo $_GET['success_update_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_update_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_update_message'])) {
                        echo $_GET['fail_update_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success_delete_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_delete_message'])) {
                        echo $_GET['success_delete_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_delete_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_delete_message'])) {
                        echo $_GET['fail_delete_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['success_create_message'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_create_message'])) {
                        echo $_GET['success_create_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_create_message'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_create_message'])) {
                        echo $_GET['fail_create_message'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['image_success'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['image_success'])) {
                        echo $_GET['image_success'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['image_failed'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['image_failed'])) {
                        echo $_GET['image_failed'];
                    } ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Customer Phone</th>
                            <th>Customer Address</th>
                            <th>Customer City</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $customer) { ?>
                            <tr class="text-wrap">
                                <td><?php echo $customer['user_id']; ?></td>
                                <td><?php echo $customer['user_name']; ?></td>
                                <td><?php echo $customer['user_phone']; ?></td>
                                <td><?php echo $customer['user_address']; ?></td>
                                <td><?php echo $customer['user_city']; ?></td> 
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>
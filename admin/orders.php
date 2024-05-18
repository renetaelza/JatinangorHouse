<?php
session_start();
include('layouts/header.php'); 

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}
?>

<?php

// Query untuk mengambil data order dan produk terkait
$query_orders = "SELECT o.order_id, o.order_cost, o.order_status, u.user_name, o.user_address, p.product_name, oi.product_quantity
                 FROM orders o
                 JOIN order_item oi ON o.order_id = oi.order_id 
                 JOIN users u ON o.user_id = u.user_id 
                 JOIN products p ON oi.product_id = p.product_id 
                 ORDER BY o.order_id DESC";

$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();

//mengelompokkan hasil berdasarkan hasil ID pesanan
$grup_orders = [];
while ($row = $orders->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($grup_orders[$order_id])) {
        $grup_orders[$order_id] = [
            'order_id' => $row['order_id'],
            'order_cost' => $row['order_cost'],
            'order_status' => $row['order_status'],
            'user_name' => $row['user_name'],
            'user_address' => $row['user_address'],
            'products' => []
        ];
    }
    //Menambahkan informasi produk ke dalam pesanan user
    $grup_orders[$order_id]['products'][] = [
        'product_name' => $row['product_name'],
        'product_quantity' => $row['product_quantity']
    ];
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Orders</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['success_status'])) { ?>
                <div class="alert alert-info" role="alert">
                    <?php if (isset($_GET['success_status'])) {
                        echo $_GET['success_status'];
                    } ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['fail_status'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php if (isset($_GET['fail_status'])) {
                        echo $_GET['fail_status'];
                    } ?>
                </div>
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Product Order</th>
                            <th>quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($grup_orders as $order) { ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['order_cost']; ?></td>
                                <td><?php echo $order['order_status']; ?></td>
                                <td><?php echo $order['user_name']; ?></td>
                                <td><?php echo $order['user_address']; ?></td>
                                <td>
                                    <?php foreach ($order['products'] as $product) { ?>
                                        <?php echo $product['product_name']; ?><br>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php foreach ($order['products'] as $product) { ?>
                                        <?php echo $product['product_quantity']; ?><br>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <a href="order_edit.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-outline-warning btn-circle">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <a href="order_delete.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-outline-danger btn-circle">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include('layouts/footer.php'); ?>
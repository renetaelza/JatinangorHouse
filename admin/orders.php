<?php
session_start();

include('layouts/header.php'); 

if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
}

// Query untuk mengambil data order dan produk terkait
$query_orders = "SELECT o.order_id, o.order_cost, o.order_status, o.order_date, o.user_address, u.user_name, u.user_phone, u.user_city, p.product_image, p.product_name, p.product_price, oi.product_quantity, oi.notes
                 FROM orders o
                 JOIN order_item oi ON o.order_id = oi.order_id 
                 JOIN users u ON o.user_id = u.user_id 
                 JOIN products p ON oi.product_id = p.product_id 
                 ORDER BY o.order_id DESC";

$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();

// mengelompokkan hasil berdasarkan hasil ID pesanan
$grup_orders = [];
while ($row = $orders->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($grup_orders[$order_id])) {
        $grup_orders[$order_id] = [
            'order_id' => $row['order_id'],
            'user_name' => $row['user_name'],
            'order_date' => $row['order_date'],
            'order_cost' => $row['order_cost'],
            'order_status' => $row['order_status'],
            'user_phone' => $row['user_phone'],
            'user_city' => $row['user_city'],
            'user_address' => $row['user_address'],
            'notes' => $row['notes'],
            'products' => []
        ];
    }
    // Menambahkan informasi produk ke dalam pesanan user
    $grup_orders[$order_id]['products'][] = [
        'product_name' => $row['product_name'],
        'product_quantity' => $row['product_quantity'],
        'product_image' => $row['product_image'],
        'product_price' => $row['product_price'],
    ];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <h1 class="h3 mx-3 text-gray-800 text-uppercase fw-bolder">Orders</h1>
    <nav class="mt-4 rounded" aria-label="breadcrumb">
        <ol class="breadcrumb px-3 py-2 rounded mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </nav>

    <!-- Display Alerts -->
    <?php if (isset($_SESSION['success_status'])) { ?>
        <div class="alert alert-info" role="alert">
            <?php 
            echo $_SESSION['success_status']; 
            unset($_SESSION['success_status']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['fail_status'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php 
            echo $_SESSION['fail_status']; 
            unset($_SESSION['fail_status']);
            ?>
        </div>
    <?php } ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grup_orders as $order) { ?>
                            <tr class="text-wrap">
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['order_status']; ?></td>
                                <td><?php echo $order['user_name']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo $order['order_cost']; ?></td>
                                <td class="text-center">
                                    <a href="order_edit.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-outline-warning btn-circle">
                                        <i class="bx bxs-edit-alt"></i>
                                    </a>
                                    <button class="btn btn-outline-info btn-circle" data-toggle="modal" data-target="#detailModal" data-order='<?php echo json_encode($order); ?>'>
                                        <i class="bx bxs-detail"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-circle" data-toggle="modal" data-target="#deleteModal" data-order_id="<?php echo $order['order_id']; ?>">
                                        <i class="bx bx-trash"></i>
                                    </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-outline-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Order Details</h5>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="GET" action="orders.php">
                    <div class="form-group">
                        <label>Order ID</label>
                        <input id="order-id" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input id="user-name" class="form-control" type="text" disabled>
                    </div>
                    <div class="container mt-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <div id="product-details">
                                    <!-- Product details will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <input id="notes" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Order</label>
                        <input id="order-date" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>Status Order</label>
                        <input id="order-status" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>Total Harga</label>
                        <input id="order-cost" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>User Phone</label>
                        <input id="user-phone" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>User City</label>
                        <input id="user-city" class="form-control" type="text" disabled>
                    </div>
                    <div class="form-group">
                        <label>User Address</label>
                        <input id="user-address" class="form-control" type="text" disabled>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var order_id = button.data('order_id');
        var modal = $(this);
        modal.find('#confirmDeleteButton').attr('href', 'order_delete.php?order_id=' + order_id);
    });

    $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var order = button.data('order');
        
        var modal = $(this);
        modal.find('#order-id').val(order.order_id);
        modal.find('#user-name').val(order.user_name);
        modal.find('#order-date').val(order.order_date);
        modal.find('#order-status').val(order.order_status);
        modal.find('#order-cost').val(order.order_cost);
        modal.find('#user-phone').val(order.user_phone);
        modal.find('#user-city').val(order.user_city);
        modal.find('#user-address').val(order.user_address);
        modal.find('#notes').val(order.notes);

        var productDetails = '';
        order.products.forEach(function (product) {
            productDetails += '<div class="d-flex align-items-center mb-2">';
            productDetails += '<img class="ml-3 mr-3" title="product_image" src="../img/product/' + product.product_image + '" style="width: 80px; height: 80px;" />';
            productDetails += '<span>Product : ' + product.product_name + '<br>';
            productDetails += 'Quantity : ' + product.product_quantity + '<br>';
            productDetails += 'Harga : ' + product.product_price + '</span>';
            productDetails += '</div>';
        });

        modal.find('#product-details').html(productDetails);
    });
</script>

<?php include('layouts/footer.php'); ?>

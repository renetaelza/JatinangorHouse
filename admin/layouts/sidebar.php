<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and other head elements -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>


<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

    
<!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-hamburger"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> Jatinangor House</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaction
    </div>

    <!-- Nav Item - Orders -->
    <li class="nav-item ">
        <a class="nav-link collapse-item" href="orders.php">
         <i class="bi bi-truck"></i>
            <span>Orders</span>
        </a>
    </li>

    <!-- Nav Item - Products -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class='bx bx-bowl-hot'></i>
            <span>Products</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Products Management</h6>
                <a class="collapse-item" href="products.php">Product List</a>
                <a class="collapse-item" href="products_create.php">Create Product</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Customers -->
    <li class="nav-item">
        <a class="nav-link" href="customers.php">
            <i class="bi bi-people-fill"></i>
            <span>Customers</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Account
    </div>

    <!-- Nav Item - Account -->
    <li class="nav-item">
        <a class="nav-link" href="#displayAccount" data-toggle="modal">
            <i class='bx bxs-face'></i>
            <span>Account</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
<!-- Modal -->
<div class="modal fade" id="displayAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Profile Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6 text-center">
                        <img src="<?php echo '/../img/profile/' . $_SESSION['admin_photo']; ?>" alt="" class="rounded-circle img-responsive" width="150" height="200" />
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <h4>
                            <?php 
                            if (isset($_SESSION['admin_name'])) {
                                echo $_SESSION['admin_name'];
                            } 
                            ?>
                        </h4>
                        <p>
                            <i class="fas fa-envelope"></i> <?php if (isset($_SESSION['admin_email'])) {
                                                                echo $_SESSION['admin_email'];} ?>
                            <br />
                            <i class="fas fa-phone"></i> <?php if (isset($_SESSION['admin_phone'])) {
                                                                echo $_SESSION['admin_phone'];} ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" href="admin_profile_edit.php" class="btn btn-outline-success">Edit</a>
                <button href="#" type="button" class="btn btn-outline-danger " data-dismiss="modal" data-target="#logoutModal">Logout</button>
            </div>
        </div>
    </div>
</div>


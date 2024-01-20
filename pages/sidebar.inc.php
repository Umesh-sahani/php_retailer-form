<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="img/avatar.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">RETAILER FORM</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link <?php  echo $_SERVER['REQUEST_URI'] == "/retailer/dashboard.php" ? "active":""; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="order_form.php" class="nav-link <?php  echo $_SERVER['REQUEST_URI'] == "/retailer/order_form.php" ? "active":""; ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>ORDER FORM</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_order.php" class="nav-link <?php  echo $_SERVER['REQUEST_URI'] == "/retailer/view_order.php" ? "active":""; ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>VIEW ORDER</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
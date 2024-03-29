<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
            <img src="<?php echo BASE_URL ?>img/avatar5.png" class='img-circle elevation-2' width="40" height="40" alt="">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
            <h4 class="h4 mb-0"><strong><?php echo $_SESSION["user_name"]; ?></strong></h4>
            <!-- <div class="mb-3">example@example.com</div> -->
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <i class="fas fa-user-cog mr-2"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a href="settings/change_password.php" class="dropdown-item <?php echo $_SERVER['REQUEST_URI'] == "/retailer/settings/change_password.php" ? "active" : "" ?>">
                <i class="fas fa-lock mr-2"></i> Change Password
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?php echo BASE_URL ?>logout.php" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
    </li>
</ul>
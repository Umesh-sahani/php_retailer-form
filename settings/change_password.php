<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

require("../config/config.php");

require_once("../database/dbcon.php");
// define variables and set to empty values
$oldPasswordErr = $newPasswordErr = $confirmPasswordErr = '';
$oldPassword = $newPassword = $confirmPassword = "";
$status = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['change_password'])) {
    $isvalid = true;
    if (empty($_POST["old_password"])) {
        $oldPasswordErr = "Enter Current Password.";
        $isvalid = false;
    } else {
        $oldPassword = test_input($_POST['old_password']);
    }

    if (empty($_POST["new_password"])) {
        $newPasswordErr = "Enter New Password.";
        $isvalid = false;
    } else {
        $newPassword = test_input($_POST['new_password']);
    }

    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Enter Confirm Password.";
        $isvalid = false;
    } else {
        $confirmPassword = test_input($_POST['confirm_password']);
    }

    if ($isvalid) {
        $username = $_SESSION["user_name"];
        if ($username) {
            $stmt = $con->prepare("SELECT * FROM `login` WHERE user_name=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($oldPassword, $row["password"])) {
                    if ($confirmPassword === $newPassword) {
                        $id = mysqli_real_escape_string($con, $row["id"]);
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $hashedPassword = mysqli_real_escape_string($con, $hashedPassword);

                        $stmt = $con->prepare("UPDATE `login` SET `password`=? WHERE `id`= ?");
                        $stmt->bind_param("si", $hashedPassword, $id);

                        if ($stmt->execute() && $stmt->affected_rows > 0) {
                            $status = "Password updated successfully.";
                            $oldPasswordErr = $newPasswordErr = $confirmPasswordErr = '';
                            $oldPassword = $newPassword = $confirmPassword = "";
                        } else {
                            $error = "Error updating password: " . $stmt->error;
                        }
                    } else {
                        $confirmPasswordErr = "Password Not Matched, Enter Correct One.";
                    }
                } else {
                    $oldPasswordErr = "Enter Correct Current Password.";
                }
            }
        }
        $stmt->close();
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RETAILER DASHBOARD PAGE <?php echo $_SESSION["user_name"];  ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/custom.css">
    <!-- website icon -->
    <link rel="shortcut icon" href="<?php echo BASE_URL ?>img/avatar.png" type="image/x-icon">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>plugins/fullcalendar/main.css">
    <!-- sweet alert  -->
    <link rel="stylesheet" href="<?php echo BASE_URL ?>plugins/sweetalert2/sweetalert2.min.css">
    <!-- sweetalert2 -->
    <script src="<?php echo BASE_URL ?>plugins/sweetalert2/sweetalert2.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Right navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <div class="navbar-nav pl-2">

            </div>
            <?php include("../pages/top_nav.php"); ?>

        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php include("../pages/sidebar.inc.php") ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h4>Change Password Form</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="../dashboard.php" class="btn btn-primary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <form class="mt-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" name="old_password" id="old_password" class="form-control <?php echo $oldPasswordErr ? "is-invalid" : "" ?>" value="<?php echo $oldPassword; ?>" placeholder="Enter Old Password">
                                            <?php if ($oldPasswordErr) : ?>
                                                <p class="invalid-feedback"><?php echo $oldPasswordErr; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control <?php echo $newPasswordErr ? "is-invalid" : "" ?>" value="<?php echo $newPassword; ?>" placeholder="Enter New Password">
                                            <?php if ($newPasswordErr) : ?>
                                                <p class="invalid-feedback"><?php echo $newPasswordErr; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo $confirmPasswordErr ? "is-invalid" : "" ?>" value="<?php echo $confirmPassword; ?>" placeholder="Enter Confirm Password">
                                            <?php if ($confirmPasswordErr) : ?>
                                                <p class="invalid-feedback"><?php echo $confirmPasswordErr; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5 pt-3">
                                    <button class="btn btn-success px-5" type="submit" name="change_password">Change Now</button>
                                    <a href="../dashboard.php" class="btn btn-outline-danger ml-3">Cancel</a>
                                </div>

                                <?php if ($status) : ?>
                                    <script>
                                        Swal.fire({
                                            title: 'Success!',
                                            text: "Password Updated Successfully.",
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                <?php elseif ($error) : ?>
                                    <script>
                                        Swal.fire({
                                            title: 'Attention!',
                                            text: "Error While Updating, Try Again.",
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- include footer page -->
        <?php include("../pages/footer.inc.php") ?>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="<?php echo BASE_URL ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE_URL ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL ?>js/adminlte.min.js"></script>
    <script src="<?php echo BASE_URL ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- fullCalendar 2.2.5 -->
    <script src="<?php echo BASE_URL ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo BASE_URL ?>plugins/fullcalendar/main.js"></script>

</body>

</html>
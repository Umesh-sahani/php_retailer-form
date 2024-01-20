<?php
session_start();


if (!isset($_SESSION['admin'])) {
	header('Location: index.php');
	exit();
}

require_once("database/dbcon.php");
require("config/config.php");

function getrows($table_name, $con, $condition = "")
{
	$sql = "SELECT COUNT(*) as total_rows FROM $table_name";

	if (!empty($condition)) {
		$sql .= " WHERE $condition";
	}
	$result = mysqli_query($con, $sql);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		$totalRows = $row["total_rows"];
		return $totalRows;
	}
}
// get all order which puch today
$conditionToday = "DATE(timestamp) = CURDATE()";
$totalTodayOrders = getRows("response", $con, $conditionToday);
// get all time order 
$totalOrders = getrows("response", $con);
// get total user registered in table
$totalUsers = getrows("login", $con);


mysqli_close($con);

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
			<?php include("pages/top_nav.php"); ?>

		</nav>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<?php include("pages/sidebar.inc.php") ?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Dashboard</h1>
						</div>
						<div class="col-sm-6">

						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>
			<!-- Main content -->
			<section class="content">
				<!-- Default box -->
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-4 col-6">
							<div class="small-box bg-danger">
								<div class="inner">
									<h3><?php echo $totalOrders; ?></h3>
									<p>Total Orders</p>
								</div>
								<div class="icon">
									<i class="fas fa-shopping-cart"></i>
								</div>
								<a href="<?php BASE_URL ?>view_order.php" class="small-box-footer">
									More info <i class="fas fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>

						<div class="col-lg-4 col-6">
							<div class="small-box bg-info">
								<div class="inner">
									<h3><?php echo $totalTodayOrders; ?></h3>
									<p>Today Orders</p>
								</div>
								<div class="icon">
									<i class="fas fa-shopping-cart"></i>
								</div>
								<a href="#" class="small-box-footer">
									More info <i class="fas fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>

						<div class="col-lg-4 col-6">
							<div class="small-box bg-gradient-success">
								<div class="inner">
									<h3><?php echo $totalUsers; ?></h3>
									<p>User Registrations</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-plus"></i>
								</div>
								<a href="#" class="small-box-footer">
									More info <i class="fas fa-arrow-circle-right"></i>
								</a>
							</div>
						</div>
					</div>
					<hr>

				</div>
				<!-- /.card -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<!-- include footer page -->
		<?php include("pages/footer.inc.php") ?>

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
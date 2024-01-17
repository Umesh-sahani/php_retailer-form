<?php
session_start();

if (!isset($_SESSION['admin'])) {
	header('Location: index.php');
	exit();
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
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="css/adminlte.min.css">
	<link rel="stylesheet" href="css/custom.css">
	<!-- website icon -->
	<link rel="shortcut icon" href="img/avatar.png" type="image/x-icon">
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

			<?php include("pages/top_nav.php") ?>

			
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
							<div class="small-box card">
								<div class="inner">
									<h3>150</h3>
									<p>Total Orders</p>
								</div>
								<div class="icon">
									<i class="ion ion-bag"></i>
								</div>
								<a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>

						<div class="col-lg-4 col-6">
							<div class="small-box card">
								<div class="inner">
									<h3>50</h3>
									<p>Total Customers</p>
								</div>
								<div class="icon">
									<i class="ion ion-stats-bars"></i>
								</div>
								<a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>

						<div class="col-lg-4 col-6">
							<div class="small-box card">
								<div class="inner">
									<h3>100</h3>
									<p>Pending</p>
								</div>
								<div class="icon">
									<i class="ion ion-person-add"></i>
								</div>
								<a href="#" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
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
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="js/adminlte.min.js"></script>
</body>

</html>
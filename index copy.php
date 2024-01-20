<?php
require_once("database/dbcon.php");
// define variables and set to empty values
$usernameErr = $passwordErr = '';
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['login'])) {
	if (empty($_POST["username"])) {
		$usernameErr = "Username is required";
	} else {
		$username = test_input($_POST['username']);
	}

	if (empty($_POST['password'])) {
		$passwordErr = "Password is required";
	} else {
		$password = test_input($_POST['password']);
	}

	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $con->prepare("SELECT * FROM `login` WHERE user_name=?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if (password_verify($password, $row['password'])) {
			session_start();
			$_SESSION['admin'] = $username;
			$_SESSION['user_name'] = $username;
			$_SESSION['order_form'] = $row['order_form'];
			$_SESSION['view_order'] = $row['view_order'];

			header('Location: dashboard.php');
			exit();
		} else {
			echo "failed";
			$passwordErr = "Incorrect password";
		}
	} else {
		$usernameErr = "Username not found";
	}

	// Close the statement
	$stmt->close();
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
	<title>Retailer Login Page.</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="css/adminlte.min.css">
	<link rel="stylesheet" href="css/custom.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box row" style="width: 600px;">
		<!-- /.login-logo -->
		<div class="card col-md-6 p-0 col-sm-0">
			<img src="img/photo1.png" alt="" style="height: 100%;width:100%">
		</div>
		<div class="card col-md-6 col-sm-12">
			<div class="card-header text-center">
				<a href="#" class="h3">RETAILER LOGIN</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Happy to see, your are back.</p>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
					<div class="input-group mb-3">
						<input type="text" class="form-control <?php echo $usernameErr ? 'is-invalid' : ''; ?>" value="<?php echo $usernameErr?"":$username ?>" id="username" name="username" placeholder="Enter User Name">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						<?php if ($passwordErr): ?>
							<div class="invalid-feedback"><?php echo $usernameErr; ?></div>
						<?php endif; ?>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control <?php echo $passwordErr ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
						<?php if ($passwordErr): ?>
							<div class="invalid-feedback"><?php echo $passwordErr; ?></div>
						<?php endif; ?>
					</div>

					<div class="row">
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
				<!-- <p class="mb-1 mt-3">
				  		<a href="forgot-password.html">I forgot my password</a>
					</p>					 -->
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
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
<?php

session_start();
if (isset($_SESSION['admin'])) {
	header('Location: dashboard.php');
	exit();
}

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
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="style.css"> -->
	<title>Retailer Login Page</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background: #ececec;
			/* background: #e9aa62; */
		}

		.right-box {
			padding: 15px 20px 15px 35px;
		}

		/*------------ Custom Placeholder ------------*/
		::placeholder {
			font-size: 16px;
		}

		.rounded-4 {
			border-radius: 15px;
		}

		.featured-image {
			position: relative;
			width: 100%;
			height: 100%;
		}

		.featured-image img {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			object-fit: fill;
			overflow: hidden;
		}


		/*------------ For small screens------------*/

		@media only screen and (max-width: 767px) {

			.box-area {
				margin: 0 15px;
			}

			.left-box {
				height: 175px;
				overflow: hidden;
			}

			.right-box {
				padding: 20px;
			}
		}
	</style>
</head>

<body>
	<!----------------------- Main Container -------------------------->
	<div class="container d-flex justify-content-center align-items-center min-vh-100 col-lg-8">
		<!----------------------- Login Container -------------------------->
		<div class="row border rounded-4 p-3 bg-white shadow box-area">
			<!--------------------------- Left Box ----------------------------->
			<div class="col-md-6 justify-content-center align-items-center left-box" style="padding: 0px;">
				<div class="featured-image">
					<img src="img/login1.jpg" class="shadow rounded">
				</div>
			</div>
			<!-------------------- ------ Right Box ---------------------------->
			<div class="col-md-6 right-box">
				<div class="row align-items-center">
					<div class="">
						<h2>Welcome, Again</h2>
						<p style="margin-bottom: 0!important;">We are happy to have you back.</p>
					</div>

					<form class="mt-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
						<div class="form-group mb-3">
							<label for="username" class="text-black">User Name</label>
							<input type="text" class="form-control form-control-lg bg-light fs-6 <?php echo $usernameErr ? 'is-invalid' : ''; ?>" value="<?php echo $usernameErr ? "" : $username ?>" id="username" name="username" placeholder="Enter User Name" autocomplete="off" maxlength="255">
							<?php if ($usernameErr) : ?>
								<div class="invalid-feedback"><?php echo $usernameErr; ?></div>
							<?php endif; ?>
						</div>


						<div class="form-group mb-4">
							<label for="password" class="text-black">Password</label>
							<input type="password" class="form-control form-control-lg bg-light fs-6 <?php echo $passwordErr ? 'is-invalid' : ''; ?>" placeholder=" Enter Password" name="password" maxlength="255">
							<?php if ($passwordErr) : ?>
								<div class="invalid-feedback"><?php echo $passwordErr; ?></div>
							<?php endif; ?>
						</div>

						<div class="input-group mb-3">
							<button type="submit" class="btn btn-lg btn-dark w-100 fs-6" name="login">Sing In</button>
						</div>
					</form>

					<div class=" mt-2">
						<small>Copyright &copy; <span>makeitsimple.</span></small>
					</div>

				</div>
			</div>

		</div>
	</div>

</body>

</html>
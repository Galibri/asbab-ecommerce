<?php
	include_once './admin/functions.php';
	if (isset($_SESSION['username'])) {
		header("Location: admin/index.php");
	}

	$login_msg = '';

	if (isset($_POST['login_submit'])) {
		$username = sanitize($_POST['username']);
		$password = sanitize($_POST['password']);
		$query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
		$result = mysqli_query($conn, $query);
		$count = mysqli_num_rows($result);
		if($count > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				if($row['password'] == $password) {
					$_SESSION['username'] = $username;
					$_SESSION['role'] = $row['role'];
					if($row['role'] == 'admin') {
						redirect('admin/index.php');
					} else {
						redirect('profile.php');
					}
					die();
				} else {
					$login_msg = 'Password did not match';
				}
			}
		} else {
			$login_msg = 'Username or password error.';
		}
	}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>User Login</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="admin/assets/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="admin/assets/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<h3>User Login</h3>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg text-danger"><?php echo $login_msg; ?></p>
				<p class="login-box-msg text-success"><?php echo (isset($_REQUEST['message']) && $_REQUEST['message'] = "registrationsuccess") ? "Registration successful. Use your uername and password to login." : ""; ?></p>

				<form action="" method="post">
					<div class="input-group mb-3">
						<input type="text" class="form-control" name="username" placeholder="Username">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="password" placeholder="Password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-info btn-block" name="login_submit">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<p class="mt-4 text-center">
					<a href="register.php" class="text-center">Register a new account.</a>
				</p>
				<!-- /.login-card-body -->
			</div>
		</div>
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="admin/assets/plugins/jquery/jquery.min.js"></script>
		<!-- Bootstrap 4 -->
		<script src="admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- AdminLTE App -->
		<script src="admin/assets/js/adminlte.min.js"></script>

</body>

</html>
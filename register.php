<?php
	include_once 'functions.php';
	if (isset($_SESSION['username'])) {
		header("Location: admin/index.php");
	}

	$register_msg = array(
		'username' => '',
		'email' => '',
		'password' => '',
		'global' => ''
	);

	if (isset($_POST['register_submit'])) {
		$username = sanitize($_POST['username']);
		$email = sanitize($_POST['email']);
		$password = sanitize($_POST['password']);
		$proceed = true;

		if(empty($username)) {
			$register_msg['username'] = "Username can't be blank.";
            $proceed = false;
		} else if( !is_unique('users', $username, 'username') ) {
			$register_msg['username'] = "Username exists. Please try another one.";
			$proceed = false;
		}

		if(empty($email)) {
			$register_msg['email'] = "Email can't be empty.";
            $proceed = false;
		} else if( !is_unique('users', $email, 'email') ) {
			$register_msg['email'] = "Email exists. Please try another one.";
			$proceed = false;
		}

		if(empty($password)) {
			$register_msg['password'] = "Please add a password";
		}

		if($proceed) {
			$data = array(
				'username' => $username,
				'email' => $email,
				'password' => $password,
				'role' => get_registration_role(),
				'status' => get_default_status()
			);
			$result = insert_into_database('users', $data);
			if($result) {
				redirect('login.php?message=registrationsuccess');
			} else {
				$register_msg['global'] = "Something went wrong. Please try in a minute.";
			}
		}
	}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>User Registration</title>
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
			<h3>User Registration</h3>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="text-danger"><?php echo $register_msg['global']; ?></p>
				<form action="" method="post">
					<div class="form-group">
						<label for="username">Username</label>
						<div class="input-group">
							<input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						<span class="text-danger"><?php echo $register_msg['username']; ?></span>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<div class="input-group">
							<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-envelope"></span>
								</div>
							</div>
						</div>
						<span class="text-danger"><?php echo $register_msg['email']; ?></span>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="password" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<span class="text-danger"><?php echo $register_msg['password']; ?></span>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-info btn-block" name="register_submit">Sign Up</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<p class="mt-4 text-center">
					<a href="login.php" class="text-center">Have an account? Login</a>
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
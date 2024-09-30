<?php
session_start();

if (isset($_SESSION["username"])) {
	header("location:home.php");
}

//Creating the database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "employeedetails";
$message = "";
try {
	$connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (isset($_POST["register"])) {
		if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirmpassword"])) {
			$message = '<label> All fields are required </label>';
		} else {
			$query = "SELECT * FROM userdetails WHERE username = :username ";
			$statement = $connect->prepare($query);
			$statement->execute(
				array(
					'username' => $_POST["username"],
				)
			);
			$count = $statement->rowCount();

			if ($count > 0) {
				$message = '<label> User Already Exist </label>';
			} else {
				if ($_POST["password"] == $_POST["confirmpassword"]) {
					$query = "INSERT INTO userdetails (username,password) VALUES (?,?)";
					$stmt = $connect->prepare($query);

					$stmt->execute([$_POST["username"], $_POST["password"]]);

					$success = '<label> User Added Successfully </label>';
				} else {
					$message = '<label> Password Does not Match </label>';
				}
			}
		}
	}
} catch (PDOException $error) {
	$message = $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Registration Form</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
						Register
					</span>

					<div class="wrap-input100 validate-input" data-validate="User Name must bt UNIQUE">
						<input class="input100" type="text" name="username" placeholder="User Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Re-Enter Password">
						<input class="input100" type="password" name="confirmpassword" placeholder="Confirm Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<input type="submit" class="login100-form-btn" value="Register" name="register">

					</div>

					<?php

					if (isset($success)) {
						echo '<br>';
						echo '<div class="text-center">';
						echo '<label class="text-success">' . $success . '</label>';

						echo '</div>';
					}

					if (isset($message)) {
						echo '<br>';
						echo '<div class="text-center">';
						echo '<label class="text-danger">' . $message . '</label>';

						echo '</div>';
					}
					?>

					<div class="text-center p-t-136">
						<a class="txt2" href="login.php">
							Already Registerd? Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>




	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>
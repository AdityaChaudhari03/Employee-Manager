<?php
//login_success.php  
session_start();
if (!isset($_SESSION["username"])) {
	header("location:login.php");
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
	if (isset($_POST["addemployee"])) {
		if (empty($_POST["firstname"]) || empty($_POST["lastname"])) {
			$message = '<label> All fields are required </label>';
		} else {
			$query = "INSERT INTO empdetails (firstname,lastname,contactnu,email) VALUES (?,?,?,?)";
			$stmt = $connect->prepare($query);

			$stmt->execute([$_POST["firstname"], $_POST["lastname"], $_POST["contactnu"], $_POST["email"]]);

			$success = '<label> User Added Successfully </label>';
		}
	}
} catch (PDOException $error) {
	$message = $error->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Home Page</title>
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
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<div class="wrap-input100 validate-input"></div>

				<div class="container-logout">
					<?php

					echo '<h1>' . $_SESSION["username"] . '</h1>';
					echo '<a href="logout.php">Logout</a>';

					?>

				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
						Employee Details
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="firstname" placeholder="First Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="lastname" placeholder="Last Name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="contactnu" placeholder="Contact Number">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-phone" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" placeholder="Email Address">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">

						<input class="login100-form-btn" type="submit" name="addemployee" value="Add Employee">

					</div>

					<?php

					if (isset($success)) {
						if (!empty($success)) {
							echo '<br>';
							echo '<div class="text-center">';
							echo '<label class="text-success">' . $success . '</label>';

							echo '</div>';
						}
					}

					if (isset($message)) {
						if (!empty($message)) {
							echo '<br>';
							echo '<div class="text-center">';
							echo '<label class="text-danger">' . $message . '</label>';

							echo '</div>';
						}
					}
					?>

					<div class="container-details">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">First Name</th>
									<th scope="col">Last Name</th>
									<th scope="col">Contact Number</th>
									<th scope="col">Email</th>
								</tr>
							</thead>
							<tbody>

								<?php

								try {
									$query = "SELECT * FROM empdetails";
									$result = $connect->query($query);

									while ($row = $result->fetch(PDO::FETCH_NUM)) {
										echo '<tr>';
										echo '<th scope="row">' . $row[0] . '</th>';
										echo '<td>' . $row[1] . '</td>';
										echo '<td>' . $row[2] . '</td>';
										echo '<td>' . $row[3] . '</td>';
										echo '<td>' . $row[4] . '</td>';
										echo '</tr>';
									}
								} catch (PDOException $e) {
									throw new PDOException($e->getMessage(), (int)$e->getCode());
								}

								?>

							</tbody>
						</table>


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
<?php 
	// Start the session
	session_start();

	if(isset($_SESSION['user'])) header('Location: product-view.php');

	$error_message = '';

	if($_POST){
		include('database/connection.php');

		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = 'SELECT * FROM users WHERE users.email="'. $username . '" AND users.password="'. $password .'" ';
		$stmt = $conn->prepare($query);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$user = $stmt->fetchAll()[0];

			// Save presently logged in user
			$_SESSION['user'] = $user;

			header('Location: product-view.php');
		} else $error_message = 'Invalid Login Credentials.';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DMS Login - Data Management Tool</title>

	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body id="loginBody">
	<?php if(!empty($error_message)) { ?>
		<div id="errorMessage">
			<strong>ERROR:</strong> <p> <?= $error_message ?> </p>
		</div>
    <?php } ?>
	<div class="container">
		<div class="loginHeader">
			<h1>DMS</h1>
			<p>Data Management Tool</p>
		</div>
		<div class="loginBody">
			<form action="login.php" method="POST">
				<div class="loginInputsContainer">
					<label for="">Username</label>
					<input placeholder="username" name="username" type="text" name="">
				</div>
				<div class="loginInputsContainer">
					<label for="">Password</label>
					<input placeholder="password" name="password" type="password" name="">
				</div>
				<div class="loginBtnContainer">
					<button>login</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
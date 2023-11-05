<?php 
	session_start();

	// unset all session variables
	session_unset();

	// destroy all session variables
	session_destroy();
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
	<h1>Logged Out</h1>
     <br>
     <h3>Back to login page</h3>  <a href="../login.php">Login</a>
</body>
</html>
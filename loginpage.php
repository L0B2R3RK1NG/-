<?php
session_start();
include("dbh.inc.php");

$error = '';

if (isset($_POST['submit'])) {
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$result = mysqli_query($conn, "SELECT * FROM gebruikers WHERE username='$username' AND wachtwoord='$password'") or die("Select Error");
	$row = mysqli_fetch_assoc($result);

	if ($row) {
		$_SESSION['loggedInUser'] = $row['id'];
		header("Location: index.php");
		exit;
	} else {
		$error = "Wrong Username or Password";
	}
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<title>Login</title>
	<style>
		.transparent-navbar {
			background: transparent;
			position: fixed;
			width: 100%;
			top: 0;
			z-index: 1000;
		}

		body {
			padding: 0;
			margin: 0;
		}

		.vid-container {
			position: relative;
			height: 100vh;
			overflow: hidden;
		}

		.bgvid {
			position: absolute;
			left: 0;
			top: 0;
			width: 100vw;
		}

		.inner-container {
			width: 400px;
			height: 400px;
			position: absolute;
			top: calc(50vh - 200px);
			left: calc(50vw - 200px);
			overflow: hidden;
		}

		.bgvid.inner {
			top: calc(-50vh + 200px);
			left: calc(-50vw + 200px);
			filter: url("data:image/svg+xml;utf9,<svg%20version='1.1'%20xmlns='http://www.w3.org/2000/svg'><filter%20id='blur'><feGaussianBlur%20stdDeviation='10'%20/></filter></svg>#blur");
			-webkit-filter: blur(10px);
			-ms-filter: blur(10px);
			-o-filter: blur(10px);
			filter: blur(10px);
		}

		.box {
			position: absolute;
			height: 100%;
			width: 100%;
			font-family: Helvetica;
			color: #fff;
			background: rgba(0, 0, 0, 0.13);
			padding: 30px 0px;
		}

		.box h1 {
			text-align: center;
			margin: 30px 0;
			font-size: 30px;
		}

		.box input {
			display: block;
			width: 300px;
			margin: 20px auto;
			padding: 15px;
			background: rgba(0, 0, 0, 0.2);
			color: #fff;
			border: 0;
		}

		.box input:focus,
		.box input:active,
		.box button:focus,
		.box button:active {
			outline: none;
		}

		.box button {
			background: #2ecc71;
			border: 0;
			color: #fff;
			padding: 10px;
			font-size: 20px;
			width: 330px;
			margin: 20px auto;
			display: block;
			cursor: pointer;
		}

		.box button:active {
			background: #27ae60;
		}

		.box p {
			font-size: 14px;
			text-align: center;
		}

		.box p span {
			cursor: pointer;
			color: #666;
		}

		.message {
			color: red;
			text-align: center;
			margin-top: 20px;
		}
	</style>
</head>

<body>

	<header class="transparent-navbar text-white">
		<div class="container d-flex justify-content-between align-items-center py-2">
			<div class="logo">アニメ金庫</div>
			<nav class="d-flex">
				<a href="homepage.php" class="text-white mx-2">Home</a>
				<a href="#" class="text-white mx-2">Catalog</a>
				<a href="#" class="text-white mx-2">News</a>
				<a href="#" class="text-white mx-2">Collections</a>
				<a href="#" class="text-white mx-2">Community</a>
			</nav>
		</div>
	</header>

	<div class="vid-container">
		<video class="bgvid" autoplay="autoplay" preload="auto" loop>
			<source src="ninja kamui.mp4" type="video/mp4">
		</video>
		<div class="inner-container">
			<video class="bgvid inner" autoplay="autoplay" preload="auto" loop>
				<source src="ninja kamui.mp4" type="video/mp4">
			</video>
			<div class="box">
				<h1>Login</h1>
				<form action="" method="post">
					<input type="text" placeholder="Username" name="username" required />
					<input type="password" placeholder="Password" name="wachtwoord" required />
					<button type="submit" name="submit">Login</button>
					<p>Not a member? <span onclick="window.location.href='signup.php'">Sign Up</span></p>

					<?php if (!empty($error)) : ?>
						<div class="message">
							<p><?php echo $error; ?></p>
						</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
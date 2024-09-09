<?php
session_start();
include("dbh.inc.php");


if (isset($_SESSION['loggedInUser'])) {
    header("Location: homepage.php");
    exit;
}

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        
        $_SESSION['loggedInUser'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];

       
        header("Location: homepage.php");
        exit;
    } else {
        $error = "Verkeerde gebruikersnaam of wachtwoord";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css/loginpagstyle.cssq">
	<title>Login</title>
</head>

<body>

	<header class="transparent-navbar text-white">
		<div class="container d-flex justify-content-between align-items-center py-2">
			<div class="logo">アニメ金庫</div>
			<nav class="d-flex">
				<a href="homepage.php" class="text-white mx-2">Home</a>
				<a href="catalog.php" class="text-white mx-2">Catalog</a>
				<a href="#" class="text-white mx-2">News</a>
			</nav>
			<div class="auth-buttons">
				<button class="btn btn-outline-light mx-2"><a href="loginpage.php">login</a></button>
				<button class="btn btn-outline-light mx-2"><a href="signup.php">Get Started</a></button>
			</div>
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
					<input type="password" placeholder="Password" name="password" required />
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
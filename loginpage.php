<?php
session_start();
include("dbh.inc.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($password == $row['password']) {
                $_SESSION['loggedInUser'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                header("Location: homepage.php");
                exit;
            } else {
                $error = "Verkeerde gebruikersnaam of wachtwoord";
            }
        } else {
            $error = "Verkeerde gebruikersnaam of wachtwoord";
        }
    } catch (PDOException $e) {
        $error = "Er is een probleem opgetreden met de database: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/loginpagstyle.css">
    <title>Login</title>
</head>
<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="homepage.php" class="text-white mx-2">Home</a>
                <a href="catalog.php" class="text-white mx-2">Catalog</a>
            </nav>
            <div class="auth-buttons">
                <a href="loginpage.php" class="btn btn-outline-light mx-2">Login</a>
                <a href="signup.php" class="btn btn-outline-light mx-2">Get Started</a>
            </div>
        </div>
    </header>

    <div class="vid-container">
        <video class="bgvid" autoplay="autoplay" preload="auto" loop>
            <source src="ninjakamui.mp4" type="video/mp4">
        </video>
        <div class="inner-container">
            <video class="bgvid inner" autoplay="autoplay" preload="auto" loop>
                <source src="ninjakamui.mp4" type="video/mp4">
            </video>
            <div class="box">
                <h1>Login</h1>
                <form method="post">
                    <input type="text" placeholder="Username" name="username" required>
                    <input type="password" placeholder="Password" name="password" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>

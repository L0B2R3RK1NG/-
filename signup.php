<?php
session_start();
include("dbh.inc.php");

$message = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message = "<p class='message error'>File is not an image.</p>";
        $uploadOk = 0;
    }

    if ($_FILES["profile_photo"]["size"] > 500000) {
        $message = "<p class='message error'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        $message = "<p class='message error'>Sorry, only JPG, JPEG, PNG files are allowed.</p>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message = "<p class='message error'>Sorry, your file was not uploaded.</p>";
    } else {
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, profile_pic) VALUES (:username, :email, :password, :profile_pic)");

                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':profile_pic', $target_file);

                $stmt->execute();

                $message = "<p class='message success'>Registration successful!</p>";
                $message .= "<a href='loginpage.php'><button class='btn'>Login Now</button></a>";
            } catch (PDOException $e) {
                $message = "<p class='message error'>Error occurred: " . $e->getMessage() . "</p>";
            }
        } else {
            $message = "<p class='message error'>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/signupstyle.css">
    <title>Sign Up</title>
</head>
<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="homepage.php" class="text-white mx-2">Home</a>
                <a href="#" class="text-white mx-2">Catalog</a>
            </nav>
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
                <h1>Sign Up</h1>
                <form method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="Username" name="username" required>
                    <input type="password" placeholder="Password" name="password" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="file" name="profile_photo" accept=".jpg, .jpeg, .png" required>
                    <button type="submit" name="submit">Register</button>
                </form>
                <div class="links" style="text-align: center;">
                    <p>Already a member? <span onclick="window.location.href='loginpage.php'">login</span></p>
                </div>
                <?php echo $message; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

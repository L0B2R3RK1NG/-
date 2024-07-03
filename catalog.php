<?php
include "seed.php";

function fetchAnimeFromDatabase()
{
    $pdo = new PDO('mysql:host=localhost;dbname=anime', 'bit_academy', 'bit_academy');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT title, image_url FROM anime');

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$animeList = fetchAnimeFromDatabase();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homecss.css">
    <style>
        body {
            background-color: #212121;
        }

        .transparent-navbar {
            background: transparent;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .hero {
            margin-top: 60px;
            position: relative;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .hero video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-buttons .btn {
            margin: 5px;
        }

        .card {
            margin-bottom: 20px;
            padding: 0;
            overflow: hidden;
        }

        .card-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .card-img-overlay {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .card-title {
            margin: 0;
        }

        a:visited {
            color: white;
            background-color: transparent;
            text-decoration: none;
        }

        a:hover {
            color: black;
            background-color: transparent;
            text-decoration: none;
        }

        hr {
            height: 0;
            border: 0;
            box-shadow: 0 0 50px 1px white;
        }

        .carousel-item .card {
            height: 300px;
        }

        .carousel-item .card .card-img {
            height: 100%;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 60px;
            padding: 20px;
        }

        .grid-item {
            position: relative;
        }

        .grid-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .grid-item .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
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
    <main>
        <section class="hero">
            <video autoplay muted loop>
                <source src="ninja kamui.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-content">
                <h1 class="display-4">Anime List</h1>
            </div>
        </section>
        <section class="anime-list py-5">
            <div class="container">
                <div class="grid-container">
                    <?php if (!empty($animeList)) { ?>
                        <?php foreach ($animeList as $anime) { ?>
                            <div class="grid-item">
                                <a href="anime.php?title=<?php echo urlencode($anime['title']); ?>">
                                    <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                    <div class="overlay">
                                        <p><?php echo htmlspecialchars($anime['title']); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="text-white">No anime data available.</p>
                    <?php } ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <a href="#" class="text-white mx-2">アニメ金庫.com</a>
            <a href="#" class="text-white mx-2">Terms & Privacy</a>
            <a href="#" class="text-white mx-2">Contacts</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

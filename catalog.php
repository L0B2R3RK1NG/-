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
    <link rel="stylesheet" href="style.css/catalog.css">
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
                <a href="loginpage.php" class="btn btn-outline-light mx-2">Login</a>
                <a href="signup.php" class="btn btn-outline-light mx-2">Get Started</a>

            </div>
        </div>
    </header>
    <main>
        <section class="hero">
            <video autoplay muted loop>
                <source src="ninjakamui.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-content">
                <h1 class="display-4">Anime List</h1>
            </div>
        </section>
        <section class="anime-list py-5">
            <h2 class="text-center text-white">Anime List</h2>
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
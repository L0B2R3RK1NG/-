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
$specialForYouList = array_slice($animeList, 0, 6);
$mostPopularList = array_slice($animeList, 6, 6);
$trendingNowList = array_slice($animeList, 12, 6);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アニメ金庫</title>
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
            padding: 5px;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-img-overlay {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 10px;
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
                <h1 class="display-4">Chainsaw Man</h1>
                <p class="lead">Denji has a simple dream—to live a happy and peaceful life, spending time with a girl he likes.</p>
                <div class="hero-buttons">
                    <button class="btn btn-light mx-2">Learn More</button>
                    <button class="btn btn-dark mx-2">To Watch</button>
                </div>
            </div>
        </section>
        <section class="special-for-you py-5">
            <div class="container">
                <h2 class="text-center mb-4">Special For You</h2>
                <div id="specialForYouCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($specialForYouList)) { ?>
                            <?php $chunkedAnimeList = array_chunk($specialForYouList, 3); ?>
                            <?php foreach ($chunkedAnimeList as $index => $animeChunk) { ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row">
                                        <?php foreach ($animeChunk as $anime) { ?>
                                            <div class="col-sm-4 mb-3">
                                                <div class="card bg-dark text-white">
                                                    <a href="anime.php?title=<?php echo urlencode($anime['title']); ?>">
                                                        <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" class="card-img" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                                        <div class="card-img-overlay">
                                                            <h5 class="card-title"><?php echo htmlspecialchars($anime['title']); ?></h5>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center w-100">No anime data available.</p>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#specialForYouCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#specialForYouCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
        <hr>
        <section class="trending-now py-5">
            <div class="container">
                <h2 class="text-center mb-4">Trending Now</h2>
                <div id="trendingNowCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($trendingNowList)) { ?>
                            <?php $chunkedTrendingList = array_chunk($trendingNowList, 3); ?>
                            <?php foreach ($chunkedTrendingList as $index => $animeChunk) { ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row">
                                        <?php foreach ($animeChunk as $anime) { ?>
                                            <div class="col-sm-4 mb-3">
                                                <div class="card bg-dark text-white">
                                                    <a href="anime.php?title=<?php echo urlencode($anime['title']); ?>">
                                                        <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" class="card-img" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                                        <div class="card-img-overlay">
                                                            <h5 class="card-title"><?php echo htmlspecialchars($anime['title']); ?></h5>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center w-100">No anime data available.</p>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#trendingNowCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#trendingNowCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
        <hr>
        <section class="most-popular py-5">
            <div class="container">
                <h2 class="text-center text-white mb-4">Most Popular</h2>
                <div id="mostPopularCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($mostPopularList)) { ?>
                            <?php $chunkedPopularList = array_chunk($mostPopularList, 3); ?>
                            <?php foreach ($chunkedPopularList as $index => $animeChunk) { ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row">
                                        <?php foreach ($animeChunk as $anime) { ?>
                                            <div class="col-sm-4 mb-3">
                                                <div class="card bg-dark text-white">
                                                    <a href="anime.php?title=<?php echo urlencode($anime['title']); ?>">
                                                        <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" class="card-img" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                                        <div class="card-img-overlay">
                                                            <h5 class="card-title"><?php echo htmlspecialchars($anime['title']); ?></h5>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center w-100">No anime data available.</p>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#mostPopularCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#mostPopularCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
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

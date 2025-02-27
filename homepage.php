<?php
session_start();
include("seed.php");

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/stylehomepage.css">
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
                <?php if (isset($_SESSION['loggedInUser']) && !empty($_SESSION['loggedInUser'])) : ?>
                    <div class="dropdown profile-section">
                        <?php
                        $pdo = new PDO('mysql:host=localhost;dbname=anime', 'bit_academy', 'bit_academy');
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $loggedin = $_SESSION['loggedInUser'];
                        $query = "SELECT username, profile_pic FROM users WHERE user_id = :loggedin";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':loggedin', $loggedin, PDO::PARAM_INT);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $username = htmlspecialchars($result['username']);
                            $profilePhoto = htmlspecialchars($result['profile_pic']);

                            if (!empty($profilePhoto)) {
                                echo '<img src="' . $profilePhoto . '" alt="Profielfoto" class="rounded-circle dropdown-toggle" width="30" height="30" data-bs-toggle="dropdown" aria-expanded="false">';
                            }

                            echo '<ul class="dropdown-menu dropdown-menu-dark">';
                            echo '<li><p class="dropdown-item disabled">' . $username . '</p></li>';
                            echo '<li><hr class="dropdown-divider"></li>';
                            echo '<li><a class="dropdown-item" href="collection.php">Collection</a></li>';
                            echo '<li><hr class="dropdown-divider"></li>';
                            echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                            echo '</ul>';
                        }
                        ?>
                    </div>
                <?php else : ?>
                    <a href="loginpage.php" class="btn btn-outline-light mx-2">Login</a>
                    <a href="signup.php" class="btn btn-outline-light mx-2">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
    <section class="hero">
    <h2 class="visually-hidden">Hero Section</h2> 
    <video autoplay muted loop>
        <source src="ninjakamui.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</section>

        <section class="special-for-you py-5">
            <div class="container">
                <h2 class="text-center text-white mb-4">Special For You</h2>
                <div id="specialForYouCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($specialForYouList)) {
                            $chunkedSpecialList = array_chunk($specialForYouList, 3);
                            foreach ($chunkedSpecialList as $index => $animeChunk) { ?>
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
                            <?php }
                        } else { ?>
                            <p class="text-center w-100">No anime data available.</p>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#specialForYouCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#specialForYouCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </section>

        <hr>

        <section class="trending-now py-5">
            <div class="container">
                <h2 class="text-center text-white mb-4">Trending Now</h2>
                <div id="trendingNowCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (!empty($trendingNowList)) {
                            $chunkedTrendingList = array_chunk($trendingNowList, 3);
                            foreach ($chunkedTrendingList as $index => $animeChunk) { ?>
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
                            <?php }
                        } else { ?>
                            <p class="text-center w-100">No anime data available.</p>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#trendingNowCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#trendingNowCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
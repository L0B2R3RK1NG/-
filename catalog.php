<?php
session_start();
function fetchAnimeFromDatabase()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=anime', 'bit_academy', 'bit_academy');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT title, image_url FROM anime');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        return [];
    }
}

$animeList = fetchAnimeFromDatabase();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アニメ金庫</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/catalog.css">
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
                        try {
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
                                } else {
                                    echo '<button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' . $username . '</button>';
                                }

                                echo '<ul class="dropdown-menu dropdown-menu-dark">';
                                echo '<li><p class="dropdown-item disabled">' . $username . '</p></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li><a class="dropdown-item" href="collection.php">Collection</a></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                                echo '</ul>';
                            }
                        } catch (PDOException $e) {
                            echo "Database Error: " . $e->getMessage();
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
                    <?php if (!empty($animeList)) : ?>
                        <?php foreach ($animeList as $anime) : ?>
                            <div class="grid-item">
                                <a href="anime.php?title=<?php echo urlencode($anime['title']); ?>">
                                    <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                    <div class="overlay">
                                        <p><?php echo htmlspecialchars($anime['title']); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-white">No anime data available.</p>
                    <?php endif; ?>
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

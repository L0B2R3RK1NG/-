<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アニメ金庫</title>
    <link rel="stylesheet" href="style/indexstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <section class="hero">
        <video autoplay muted loop>
            <source src="ninjakamui.mp4" type="video/mp4">
        </video>

        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand text-light" href="#">アニメ金庫</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="catalog.php">Catalog</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <h1>アニメ金庫</h1>
            <h6>#1 Animepage for all activities</h6>
            <a href="homepage.php" class="btn btn-light">HOME</a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
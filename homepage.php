<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アニメ金庫</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="homecss.css">
    <style>
        .transparent-navbar {
            background: transparent;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .card {
            margin-bottom: 20px;
            padding: 5px;
        }
        .card-img {
            width: 100%;
            height: auto;
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
        .hero {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="#" class="text-white mx-2">Home</a>
                <a href="#" class="text-white mx-2">Catalog</a>
                <a href="#" class="text-white mx-2">News</a>
                <a href="#" class="text-white mx-2">Collections</a>
                <a href="#" class="text-white mx-2">Community</a>
            </nav>
            <div class="auth-buttons">
                <button class="btn btn-outline-light mx-2"><a href="loginpage.php">login</a></button>
                <button class="btn btn-light">Get Started</button>
            </div>
        </div>
    </header>
    <main>
        <section class="hero text-center text-white d-flex flex-column justify-content-center align-items-center" style="background: url('chainsaw-man-bg.jpg') no-repeat center center/cover; height: 60vh;">
            <div class="hero-content">
                <h1 class="display-4">Chainsaw Man</h1>
                <p class="lead">Denji has a simple dream—to live a happy and peaceful life, spending time with a girl he likes.</p>
                <div class="hero-buttons">
                    <button class="btn btn-light mx-2">Learn More</button>
                    <button class="btn btn-dark mx-2">To Watch</button>
                </div>
            </div>
        </section>
        <section class="special-for-you  py-5 ">
            <div class="container">
                <h2 class="text-center mb-4"> Special For You</h2>
                <div id="specialForYouCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item w-100 active">
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 1</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 2</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 3</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item w-100">
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 4</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 5</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <div class="card bg-dark text-white">
                                        <img class="card-img" src="image/erased.jpeg" alt="Card image">
                                        <div class="card-img-overlay">
                                            <h5 class="card-title">Card title 6</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        <section class="featured-collections py-5 bg-secondary">
            <div class="container">
                <h2 class="text-center text-white mb-4">Featured Collections</h2>
                <div class="row">
                    <div class="col-sm-  mb-3">
                        <div class="card bg-dark text-white">The Best Mystical Anime</div>
                    </div>
                    <div class="col-sm-  mb-3">
                        <div class="card bg-dark text-white">Top 20 Romance Anime</div>
                    </div>
                    <div class="col-sm-  mb-3">
                        <div class="card bg-dark text-white">The Best Classic Anime</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="trending-now py-5">
            <div class="container">
                <h2 class="text-center mb-4">Trending Now</h2>
                <div class="row">
                    <!-- Repeat this column for each card -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Trending 1</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Trending 2</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Trending 3</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Trending 4</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Trending 5</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="most-popular py-5 bg-secondary">
            <div class="container">
                <h2 class="text-center text-white mb-4">Most Popular</h2>
                <div class="row">
                    <!-- Repeat this column for each card -->
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Popular 1</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Popular 2</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Popular 3</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Popular 4</div>
                    </div>
                    <div class="col-md-2 col-sm-4 mb-3">
                        <div class="card bg-dark text-white">Popular 5</div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <a href="#" class="text-white mx-2">kurosaw.com</a>
            <a href="#" class="text-white mx-2">Terms & Privacy</a>
            <a href="#" class="text-white mx-2">Contacts</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

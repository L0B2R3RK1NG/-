<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Background</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
       
        .hero video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            
        }

        
        .hero {
            position: relative;
            height: 100vh;
            
        }




       
        .navbar-brand {
            font-size: 30px;
            font-weight: bold;
            color: white;
        }

        
        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

       
        .content a:hover {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
    </style>
</head>

<body>
    <section class="hero">
        <video autoplay loop>
            <source src="ninja kamui.mp4" type="video/mp4">
        </video>

        
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand text-light" href="#">アニメ金庫</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        
        <div class="content">
            <h1>アニメ金庫</h1>
            <h6>#1 Animepage for all activities</h6>
            <a href="homepage.php" class="btn btn-light">HOME</a>
        </div>
    </section>

    <
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
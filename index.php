<?php
require_once("conn.php");
require_once("auth.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Tes Kecerdasan</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/ss.css">
</head>

<body id="page-top"><a href="#" class="menu-toggle rounded new-menu"><i class="fa fa-bars"></i></a>
    <?php
    if (isset($_SESSION['user'])) 
    {
        $user = $_SESSION['user'];
        $u = $user['username'];
        echo "
        <div class='dropdown rounded new-drp'><button class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-expanded='false' type='button'><i class='fa fa-user'></i><span>&nbsp;&nbsp;</span><span>&nbsp;$u</span><span>&nbsp;&nbsp;</span></button>
            <div class='dropdown-menu' role='menu'>
                <a class='dropdown-item' role='presentation' href='profile'>
                    <img src='assets/img/SEA%20Logo.png' style='max-width: 20px;max-height: 20px; margin-left:0;'>&nbsp; $u
                </a>
                <div class='dropdown-divider' role='presentation'></div>
                <a class='dropdown-item' role='presentation' href='edit_profile'>Edit Profile</a>
                <a class='dropdown-item' role='presentation' href='hasil'>Lihat Hasil</a>
                <div class='dropdown-divider' role='presentation'></div>
                <a class='dropdown-item' role='presentation' href='logout'>Logout</a>
            </div>
        </div>";
    }
    
    ?>
    <nav class="navbar navbar-light navbar-expand new-navbar" id="sidebar-wrapper">
        <div class="container"><button class="navbar-toggler d-none" data-toggle="collapse" data-target="#"></button>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav sidebar-nav" id="sidebar-nav" style="padding: 20px;">
                    <li class="nav-item sidebar-nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="index">Home</a></li>
                    <li class="nav-item sidebar-nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="peraturan?id=1">Soal</a></li>
                    <li class="nav-item sidebar-nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="nilai">Nilai</a></li>
                    <li class="nav-item sidebar-nav-item" role="presentation"><a class="nav-link js-scroll-trigger" href="profile">Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="d-flex masthead" style="background-image:url('assets/img/bg-masthead.jpg');">
        <div class="container my-auto text-center">
            <h1 class="mb-1">Tes Kecerdasan</h1>
            <h3 class="mb-5"><em>By : min4tozaki</em></h3>
            <?php
            if (isset($_SESSION['user'])) echo "<a class='btn btn-primary btn-xl js-scroll-trigger' role='button' href='pilih_soal' style='padding-top: 15px;padding-bottom: 15px;'>Kerjakan Soal</a>";
            else echo "<a class='btn btn-primary btn-xl js-scroll-trigger' role='button' href='login' style='padding-top: 15px;padding-bottom: 15px;'>Login / Register</a>";
            ?>
            <div class="overlay"></div>
        </div>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/stylish-portfolio.js"></script>
</body>

</html>
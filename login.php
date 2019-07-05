<?php
require_once("conn.php");
require_once("auth.php");
if(isset($_SESSION["user"])){
    header("location: profile");
}
if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    echo $username . $password;
    $sql = "SELECT * FROM tbl_user WHERE username=:username";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // jika user terdaftar
    if ($user) {
        // verifikasi password
        $pass=$user['password'];
        if ($password == $pass) {
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            $_SESSION["username"] = $username;
            header("location: profile");
        }
    }
}
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
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css" />
    <link rel="stylesheet" href="assets/css/ss.css">
</head>

<body id="page-top"><a href="#" class="menu-toggle rounded new-menu"><i class="fa fa-bars"></i></a>
    
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
    <header class="d-flex masthead login-clean" style="background-image:url('assets/img/bg-masthead.jpg');">
        <div class="container my-auto text-center">
            <form method="post" style="background-color: rgba(81,89,91,0.76);color: rgb(255,255,255);">
                <div class="illustration"><i class="fa fa-user" style="color: rgb(255,255,255);"></i></div>
                <div class="form-group"><input type="text" name="username" placeholder="Username" class="form-control" style="color: black;" ></div>
                <div class="form-group"><input type="password" name="password" placeholder="Password" class="form-control" style="color: black;" ></div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit" name="login" value="login">Log In</button>
                </div>
                    <a href="forgot" class="forgot" style="color: white;">Forgot Password</a>
                    <a href="register" class="forgot" style="margin-top: 5px;color: white;">Register</a>
            </form>
        </div>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="assets/js/stylish-portfolio.js"></script>
</body>

</html>
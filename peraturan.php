<?php
require_once("conn.php");
require_once("auth.php");
$user=$_SESSION['user'];
$id = $_GET['id'];


$sql = "SELECT * FROM tabel_soal WHERE id_soal=$id";
$stmt = $db->prepare($sql);
// bind parameter ke query

$stmt->execute();

$data = $stmt->fetchAll();

$sql = "SELECT * FROM tbl_peraturan WHERE id=:id";
$stmt = $db->prepare($sql);
// bind parameter ke query
$params = array(
    ":id" => $id
);
$stmt->execute($params);
$soal = $stmt->fetch(PDO::FETCH_ASSOC);
if($data == $soal)
    header('location:nilai');
if (isset($_POST['mulai'])){
    if(isset($_POST['ceklis'])){
        $cek = $_POST["ceklis"];
        header("Location: soal?id=$id");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
</head>

<body id="page-top"><a href="#" class="menu-toggle rounded new-menu"><i class="fa fa-bars"></i></a>
    <div class="dropdown rounded new-drp"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fa fa-user"></i><span>&nbsp;&nbsp;</span><span>&nbsp;<?php echo $user['username'] ?></span><span>&nbsp;&nbsp;</span></button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item" role="presentation" href="profile">
                <img src="assets/img/SEA%20Logo.png" style="max-width: 20px;max-height: 20px; margin-left:0;">&nbsp; <?php echo $user['username'] ?>
            </a>
            <div class="dropdown-divider" role="presentation"></div>
            <a class="dropdown-item" role="presentation" href="edit_profile">Edit Profile</a>
            <a class="dropdown-item" role="presentation" href="hasil">Lihat Hasil</a>
            <div class="dropdown-divider" role="presentation"></div>
            <a class="dropdown-item" role="presentation" href="logout">Logout</a>
        </div>
    </div>
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
    <header class="d-flex masthead login-clean" style="background-image: url('assets/img/bg-masthead.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-position: center; height:100%; background-size: cover;">
        <div class="container my-auto">
            <form style="background-color: rgba(81,89,91,0.76); max-width:none;" style="te" method="POST">
                <div>
                    <h5 class="text-left" style="color:white">Peraturan</h5>
                    <hr>
                    <h2 class="text-center card-title" style="margin-bottom: 20px; color:white"><?php echo $soal['nama_ujian']; ?></h2>
                    <h6 class="card-subtitle mb-2" style="color:white">Waktu Pengerjaan :&nbsp;<?php echo $soal['waktu']; ?> Menit</h6>
                    <h6 class="card-subtitle mb-2" style="color:white">Jumlah Soal :&nbsp;20 Soal</h6>
                    <h6 class="card-subtitle mb-2" style="color:white">Nilai Minimal :&nbsp;<?php echo $soal['nilai_min']; ?></h6>
                    <h3 class="text-center card-title" style="color:white;margin: 30px 0px;">PERATURAN DAN CONTOH UNTUK KELOMPOK SOAL 01 - 20</h3>
                    <div style="color:white"><?php echo $soal['peraturan']; ?></div>
                    <div class="form-check" style="color: white;margin: 30px 0px;">
                        <input class="form-check-input" type="checkbox" id="formCheck" name="ceklis" value="1" required oninvalid="this.setCustomValidity('Silahkan diceklis')" oninput="setCustomValidity('')">
                        <label class="form-check-label" for="formCheck">Saya mengerti dan siap untuk mengikuti tes</label>
                    </div>
                    <button class="btn btn-info btn-block" type="submit" name="mulai" style="margin-top: 10px;">Mulai Tes</button>
                </div>
            </form>

        </div>

    </header>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script src="assets/js/stylish-portfolio.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
</body>

</html>



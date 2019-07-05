<?php
require_once("conn.php");
require_once("auth.php");
$user = $_SESSION['user'];
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
$per = $stmt->fetch(PDO::FETCH_ASSOC);
if($data == $per)
    header('location:nilai');
if (isset($_POST['selesai'])) {
    $benar = 0;
    $salah = 0;
    $kosong = 0;
    $id_soal = $id;
    $id_user = $user['id_user'];
    $tanggal = date("Y-m-d");
    foreach ($data as $row) {
        $knc_jawaban = $row['knc_jawaban'];
        $knc_jawaban2 = $row['knc_jawaban2'];
        $i = $row['no_soal'];
        if ($id != 4) {
            if (isset($_POST[$i])) {
                if ($knc_jawaban == $_POST[$i])
                    $benar += 1;
                else
                    $salah += 1;
            } else
                $kosong += 1;
        } else {
            if (isset($_POST["jawaban_$i"])) {
                if ($knc_jawaban == $_POST["jawaban_$i"]) {
                    $benar += 2;
                    echo "nomor $i benar";
                } else if ($knc_jawaban2 == $_POST["jawaban_$i"])
                    $benar += 1;
                else
                    $salah += 1;
            } else
                $kosong += 1;
        }
    }
    $score = $benar * 5;
    if ($score >= 50)
        $keterangan = "Lulus";
    else
        $keterangan = "Tidak Lulus";
    $upSql = "INSERT INTO tbl_nilai (id_user, id_soal, benar, salah, kosong, score, tanggal, keterangan) 
            VALUES(:id_user, :id_soal, :benar, :salah, :kosong, :score, :tanggal, :keterangan)";
    $stmt = $db->prepare($upSql);
    // bind parameter ke query
    $params = array(
        ":id_user" => $id_user,
        ":id_soal" => $id_soal,
        ":benar" => $benar,
        ":salah" => $salah,
        ":kosong" => $kosong,
        ":score" => $score,
        ":tanggal" => $tanggal,
        ":keterangan" => $keterangan
    );
    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    $newId =(int)$id+1;
    header('location:peraturan?id='.$newId);
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

<body id="page-top">
    <a href="#" class="menu-toggle rounded new-menu"><i class="fa fa-bars"></i></a>
    <div class="rounded new-drp2" style="font-size:29px;">
        <p class="text-center" style="margin-top:0px;margin-bottom:-50px;font-size:24px;color: rgb(255,255,255);padding:2px 10px;height:46px;">
            <label>Waktu </label>
            <label id="minutes">0<?php echo $per['waktu']; ?></label> : <label id="seconds">00</label>
        </p>
    </div>
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
    <header class="d-flex masthead login-clean" style="background-image: url('assets/img/bg-masthead.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-position: center; height:auto;background-size: cover;">
        <div class="container my-auto">

            <form id="myform" style="background-color: rgba(81,89,91,0.76);width: 700px; max-width:none;" style="te" method="post">
                <h2 style="font-size: 54px;color: rgb(255,255,255);padding-top: 20px;padding-bottom: 11px;">Soal</h2>
                <?php
                foreach ($data as $row) {
                    $no = $row['no_soal'];
                    $soal = $row['soal'];
                    $a = $row['a'];
                    $b = $row['b'];
                    $c = $row['c'];
                    $d = $row['d'];
                    $e = $row['e'];
                    echo "
                        <div class='form-group'>
                            <div class='form-row'>
                                <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>
                                    <p style='color: white;'>$no .</p>
                                </div>
                                <div class='col'>
                                    <p style='margin-bottom: 5px;color: white;'>$soal</p>
                                    ";
                    if ($id != 4) {
                        echo "
                                    <div>
                                        <div class='form-check d-inline'>
                                        <input class='form-check-input' type='radio' name='$no' value='a' id='formCheck-1'><label class='form-check-label' style='color: white;' for='formCheck-1'>$a</label></div>
                                    </div>
                                    <div>
                                        <div class='form-check d-inline'>
                                        <input class='form-check-input' type='radio' name='$no' value='b' id='formCheck-1'><label class='form-check-label' style='color: white;' for='formCheck-1'>$b</label></div>
                                    </div>
                                    <div>
                                        <div class='form-check d-inline'>
                                        <input class='form-check-input' type='radio' name='$no' value='c' id='formCheck-1'><label class='form-check-label' style='color: white;' for='formCheck-1'>$c</label></div>
                                    </div>
                                    <div>
                                        <div class='form-check d-inline'>
                                        <input class='form-check-input' type='radio' name='$no' value='d' id='formCheck-1'><label class='form-check-label' style='color: white;' for='formCheck-1'>$d</label></div>
                                    </div>
                                    <div>
                                        <div class='form-check d-inline'>
                                        <input class='form-check-input' type='radio' name='$no' value='e' id='formCheck-1'><label class='form-check-label' style='color: white;' for='formCheck-1'>$e</label></div>
                                    </div>
                                    ";
                    } else echo "
                                    <div>
                                        <input class='form-control d-inline' type='text' name='jawaban_$no' style='max-width: 200px;max-height: 20px;margin-left: 0px;padding:0px'></input>
                                    </div>
                                    ";
                    echo "
                                </div>
                            </div>
                        </div>
                        ";
                } ?>
                <button id="selesai" class="btn btn-primary text-left" type="submit" style="margin-bottom: 20px;" name="selesai">Button</button>
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

<?php
?>
<script>
    autosize(document.getElementById("note"));
    var minutesLabel = document.getElementById("minutes");
    var secondsLabel = document.getElementById("seconds");
    var totalSeconds = <?php echo $per['waktu'];?> * 60;

    function setTime() {
        --totalSeconds;
        secondsLabel.innerHTML = pad(totalSeconds % 60);
        minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
        if(totalSeconds == 0)
            document.getElementById("selesai").click();
    }

    function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
            return "0" + valString;
        } else {
            return valString;
        }
    }
    setInterval(setTime, 1000);
</script>
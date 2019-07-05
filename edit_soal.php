<?php
require_once("conn.php");
require_once("auth.php");
$user = $_SESSION['user'];
$id = $_GET['id'];
// if ($id == 1) $tbl = 'tbl_soal';
// else $tbl = "tbl_soal$id";
$sql = "SELECT * FROM tabel_soal WHERE id_soal=$id";
$stmt = $db->prepare($sql);
// bind parameter ke query

$stmt->execute();

$data = $stmt->fetchAll();
if (isset($_POST['save'])) {
    foreach ($data as $row) {
        $no = $row['no_soal'];
        $id_soal = $row['id_soal'];
        $soal = nl2br(filter_input(INPUT_POST, "soal_$no", FILTER_SANITIZE_STRING));
        if($id != 4){
            $a = filter_input(INPUT_POST, "a_$no", FILTER_SANITIZE_STRING);
            $b = filter_input(INPUT_POST, "b_$no", FILTER_SANITIZE_STRING);
            $c = filter_input(INPUT_POST, "c_$no", FILTER_SANITIZE_STRING);
            $d = filter_input(INPUT_POST, "d_$no", FILTER_SANITIZE_STRING);
            $e = filter_input(INPUT_POST, "e_$no", FILTER_SANITIZE_STRING);
            $knc_jawaban = filter_input(INPUT_POST, "knc_jawaban_$no", FILTER_SANITIZE_STRING);
            $upSql = "UPDATE tabel_soal SET soal=:soal,
                                    a=:a,
                                    b=:b,
                                    c=:c,
                                    d=:d,
                                    e=:e,
                                    knc_jawaban=:knc_jawaban
                    WHERE no_soal=:no_soal and id_soal=:id_soal";
            $stmt = $db->prepare($upSql);
            // bind parameter ke query
            $params = array(
                ":soal" => $soal,
                ":a" => $a,
                ":b" => $b,
                ":c" => $c,
                ":d" => $d,
                ":e" => $e,
                ":knc_jawaban" => $knc_jawaban,
                ":no_soal" => $no,
                "id_soal" => $id_soal
            );
        }
        else{
            $poin2 = filter_input(INPUT_POST, "poin2_$no", FILTER_SANITIZE_STRING);
            $poin1 = filter_input(INPUT_POST, "poin1_$no", FILTER_SANITIZE_STRING);
            $upSql = "UPDATE tabel_soal SET soal=:soal,
                                    knc_jawaban=:knc_jawaban,
                                    knc_jawaban2=:knc_jawaban2
                    WHERE no_soal=:no_soal and id_soal=:id_soal";
            $stmt = $db->prepare($upSql);
            // bind parameter ke query
            $params = array(
                ":soal" => $soal,
                ":knc_jawaban" => $poin2,
                ":knc_jawaban2" => $poin1,
                ":no_soal" => $no,
                "id_soal" => $id_soal
            );
        }
            // eksekusi query untuk menyimpan ke database
            $saved = $stmt->execute($params);
            header('location:edit_soal?id='.$id);
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
    <header class="d-flex masthead login-clean" style="background-image: url('assets/img/bg-masthead.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-position: center; height:auto;background-size: cover;">
        <div class="container my-auto">
            <form style="background-color: rgba(81,89,91,0.76);width: 700px; max-width:none;" style="te" method="POST">
                <h2 style="font-size: 54px;color: rgb(255,255,255);padding-top: 20px;padding-bottom: 11px;">Soal</h2>
                <?php
                foreach ($data as $row) {
                    $no = $row['no_soal'];
                    $soal = $row['soal'];
                    $soal = preg_replace('#<br\s*/?>#', "", $soal);
                    $a = $row['a'];
                    $b = $row['b'];
                    $c = $row['c'];
                    $d = $row['d'];
                    $e = $row['e'];
                    $knc_jawaban = $row['knc_jawaban'];
                    $knc_jawaban2 = $row['knc_jawaban2'];
                    echo "
                <div class='form-group'>
                    <div class='form-row'>
                        <div class='col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1'>
                            <p style='color: white;'>$no .</p>
                        </div>
                        <div class='col'>
                            <div style='margin-bottom:20px;'>
                                <textarea class='form-control' id='note_$no' name='soal_$no' style='margin-bottom: 20px;min-height: 80px;'>$soal</textarea>
                                ";
                    if ($id != 4) {
                        echo "
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='color: white;'>A.</span>
                                    <input class='form-control d-inline' type='text' name='a_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$a'>
                                </div>
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='color: white;'>B.</span>
                                    <input class='form-control d-inline' type='text' name='b_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$b'>
                                </div>
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='color: white;'>C.</span>
                                    <input class='form-control d-inline' type='text' name='c_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$c'>
                                </div>
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='color: white;'>D.</span>
                                    <input class='form-control d-inline' type='text' name='d_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$d'>
                                </div>
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='color: white;'>E.</span>
                                    <input class='form-control d-inline' type='text' name='e_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$e'>
                                </div>
                                <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                                    <span class='d-inline' style='margin-right: 10px;color: white;'>Jawaban yang benar :</span>
                                    <select class='form-control' style='max-width: 50px;max-height: 20px;' name='knc_jawaban_$no'>
                                        <option value='a'";
                        if ($knc_jawaban == 'a') echo " selected";
                        echo ">A</option>
                                                                    <option value='b'";
                        if ($knc_jawaban == 'b') echo "selected";
                        echo ">B</option>
                                                                    <option value='c'";
                        if ($knc_jawaban == 'c') echo "selected";
                        echo ">C</option>
                                                                    <option value='d'";
                        if ($knc_jawaban == 'd') echo "selected";
                        echo ">D</option>
                                                                    <option value='e'";
                        if ($knc_jawaban == 'e') echo "selected";
                        echo ">E</option>
                                        </select>
                                    </div>
                                </div>";
                    } else echo "<div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                    <span class='d-inline' style='margin-right: 10px;color: white;'>Jawaban Poin 2 :</span>
                    <input class='form-control d-inline' type='text' name='poin2_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$knc_jawaban'>
                    </div>
                    <div class='d-xl-flex align-items-xl-center' style='padding: 10px;'>
                    <span class='d-inline' style='margin-right: 10px;color: white;'>Jawaban Poin 1 :</span>
                    <input class='form-control d-inline' type='text' name='poin1_$no' style='max-width: 200px;max-height: 20px;margin-left: 10px;padding:0px' value='$knc_jawaban2'>
                    </div>
                    </div>";
                    echo " </div> </div>";
                } ?>
                                            <button class=" btn btn-primary text-left" type="submit" name="save" style="margin-bottom: 20px;">Selesai</button>
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
foreach ($data as $row) {
    $i = $row['no_soal'];
    echo "<script>autosize(document.getElementById('note_$i'))</script>";
}
?>
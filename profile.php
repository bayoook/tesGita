<?php
require_once("conn.php");
require_once("auth.php");
$data=$_SESSION['user'];
if (isset($_POST['save'])) {
    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $tgl_lahir = filter_input(INPUT_POST, 'tgl_lahir', FILTER_SANITIZE_STRING);
    $jk = filter_input(INPUT_POST, 'jk', FILTER_SANITIZE_STRING);
    $agama = filter_input(INPUT_POST, 'agama', FILTER_SANITIZE_STRING);
    $kwgn = filter_input(INPUT_POST, 'kwgn', FILTER_SANITIZE_STRING);
    $nama_ayah = filter_input(INPUT_POST, 'nama_ayah', FILTER_SANITIZE_STRING);
    $nama_ibu = filter_input(INPUT_POST, 'nama_ibu', FILTER_SANITIZE_STRING);
    $pekerjaan_ayah = filter_input(INPUT_POST, 'pekerjaan_ayah', FILTER_SANITIZE_STRING);
    $pekerjaan_ibu = filter_input(INPUT_POST, 'pekerjaan_ibu', FILTER_SANITIZE_STRING);
    $sekolah_asal = filter_input(INPUT_POST, 'sekolah_asal', FILTER_SANITIZE_STRING);
    $telp = filter_input(INPUT_POST, 'telp', FILTER_SANITIZE_STRING);
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    $id_user = $data['id_user'];

    // // menyiapkan query
    $sql = "UPDATE tbl_user SET username=:username, 
                            nama=:nama, 
                            tgl_lahir=:tgl_lahir,
                            jk=:jk,
                            agama=:agama,
                            kwgn=:kwgn,
                            nama_ayah=:nama_ayah,
                            nama_ibu=:nama_ibu,
                            pekerjaan_ayah=:pekerjaan_ayah,
                            pekerjaan_ibu=:pekerjaan_ibu,
                            sekolah_asal=:sekolah_asal,
                            telp=:telp,
                            alamat=:alamat
            WHERE id_user=:id_user";
    $stmt = $db->prepare($sql);
    // bind parameter ke query
    $params = array(
        ":nama" => $nama,
        ":username" => $username,
        ":tgl_lahir" => $tgl_lahir,
        ":jk" => $jk,
        ":agama" => $agama,
        ":kwgn" => $kwgn,
        ":nama_ayah" => $nama_ayah,
        ":nama_ibu" => $nama_ibu,
        ":pekerjaan_ayah" => $pekerjaan_ayah,
        ":pekerjaan_ibu" => $pekerjaan_ibu,
        ":sekolah_asal" => $sekolah_asal,
        ":telp" => $telp,
        ":alamat" => $alamat,
        ":id_user" => $id_user
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);
    // jika query simpan berhasil, maka user sudah terdaftar
    // maka alihkan ke halaman login
    if ($saved) {
        $sql = "SELECT * FROM tbl_user WHERE id_user=:id_user";
        $stmt = $db->prepare($sql);
        $params = array(
            ":id_user" => $id_user
        );
        $stmt->execute($params);
        $data = $user;
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = $user;
        header("Location: profile");
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
    <link rel="stylesheet" href="assets/css/ss.css">
</head>

<body id="page-top"><a href="#" class="menu-toggle rounded new-menu"><i class="fa fa-bars"></i></a>
    <div class="dropdown rounded new-drp"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fa fa-user"></i><span>&nbsp;&nbsp;</span><span>&nbsp;<?php echo $data['username'] ?></span><span>&nbsp;&nbsp;</span></button>
        <div class="dropdown-menu" role="menu">
            <a class="dropdown-item" role="presentation" href="profile">
                <img src="assets/img/SEA%20Logo.png" style="max-width: 20px;max-height: 20px; margin-left:0;">&nbsp; <?php echo$data['username'] ?>
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
    <header class="d-flex masthead" style="background-image: url(&quot;assets/img/bg-callout.jpg&quot;);">
        <div class="container my-auto text-center">
            <form class="rounded shadow-lg" style="background-color: rgba(81,89,91,0.76);width: 500px;" method="post">
                <h2 style="font-size: 54px;color: rgb(255,255,255);padding-top: 20px;padding-bottom: 11px;">Profile</h2>
                <div class="table-responsive" style="color: rgb(255,255,255);">
                    <table class="table">
                        <tbody style="padding-left: 30px;">
                            <tr>
                                <td style="padding-right: 0px;">Username</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="username" value="<?php echo $data['username'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Nama Lengkap</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="nama" value="<?php echo $data['nama'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Tanggal Lahir</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="date" style="height: 30px;" name="tgl_lahir" value="<?php echo $data['tgl_lahir'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Jenis Kelamin</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td>
                                    <select class="form-control" style="height: 30px;" name="jk" >
                                        <optgroup label="Jenis Kelamin">
                                            <option value="Laki-laki" 
                                            <?php if ($data['jk'] == 'Laki-laki'){
                                                echo "selected";
                                            }?>>Laki-laki</option>
                                            <option value="Perempuan" 
                                            <?php if ($data['jk'] == 'Perempuan'){
                                                echo "selected";
                                            }?>>Perempuan</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Agama</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="agama" value="<?php echo $data['agama'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Kewarganegaraan</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="kwgn" value="<?php echo $data['kwgn'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Nama Ayah</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="nama_ayah" value="<?php echo $data['nama_ayah'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Nama Ibu</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="nama_ibu" value="<?php echo $data['nama_ibu'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Pekerjaan Ayah</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="pekerjaan_ayah" value="<?php echo $data['pekerjaan_ayah'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Pekerjaan Ibu</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="pekerjaan_ibu" value="<?php echo $data['pekerjaan_ibu'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Sekolah Asal</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="text" style="height: 30px;" name="sekolah_asal" value="<?php echo $data['sekolah_asal'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Nomor Telepon</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><input class="form-control" type="telp" style="height: 30px;" name="telp" value="<?php echo $data['telp'] ?>"></td>
                            </tr>
                            <tr>
                                <td style="padding-right: 0px;">Alamat</td>
                                <td style="width: 1px;padding: 6px 0px;">:</td>
                                <td><textarea id="note" class="form-control" name="alamat"><?php echo $data['alamat'] ?></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" type="submit" name="save" style="margin-bottom:20px;">Save</button>
                </div>
            </form>
        </div>
    </header>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script src="assets/js/stylish-portfolio.js"></script>
</body>

</html>


<script>
autosize(document.getElementById("note"));
</script>
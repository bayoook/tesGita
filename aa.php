<?php
$sql = "INSERT INTO tabel_soal (id_soal, no_soal) VALUES";

for ($i = 1; $i <= 20; $i++) {
    $sql .= "('4','$i')";
    if ($i <= (20)) {
        $sql .= ",";
    }
}
echo $sql;

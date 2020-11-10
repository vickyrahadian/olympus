<?php

$data = $_POST['myJson'];

$nama_file      = $data[0][0];
$lokasi_awal    = $data[0][1];
$lokasi_akhir   = $data[0][2];

//echo $_SERVER["PHP_SELF"];
//rename()
$path_awal = '../../../' . $lokasi_awal . $nama_file;
$path_akhir = '../../../' . $lokasi_akhir . $nama_file;

echo rename($path_awal, $path_akhir);

?>
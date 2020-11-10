<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//7777 = AKTIFKAN

header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

require('../../fungsi.php');
konek_db();

$data = $_POST['myJson'];
$pesan = "";

@$user = $data[0][1];
@$id = $data[0][2];
@$search = $data[0][96];
@$kode = $data[0][97];
@$hal = $data[0][98];
@$lim = $data[0][99];

$json = array();
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

if ($kode == '1111') {
    $sql = "SELECT nama, kode, SUM(jumlah) as jumlah FROM barang b, penjualan_detail p WHERE b.id_barang = p.id_barang GROUP BY (b.id_barang) ORDER BY jumlah DESC LIMIT 10";
}

$result = mysql_query($sql);
$totalrow = mysql_num_rows($result);

if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'nama' => $row['nama'],
            'kode' => $row['kode'],
            'jumlah' => $row['jumlah'],
            'totalrow' => $totalrow            
        );
    }
}
echo json_encode($json);
?>
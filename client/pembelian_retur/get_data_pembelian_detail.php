<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT ALL DATA NO LIMIT
//2222 = UPDATE
//3333 = DELETE
//4444 = INSERT
//5555 = SEARCHSIMPLE AKTIF
//5556 = SEARCHSIMPLE TIDAK AKTIF
//5557 = SEARCH ON LIMIT
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

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

if ($kode == '5557') {
    $sql = "SELECT *, (SELECT COUNT(*) FROM barang_persediaan WHERE id_pembelian = $id) as totaldata FROM barang_persediaan bp JOIN barang b ON bp.id_barang = b.id_barang WHERE id_pembelian = $id";
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
            'id_pembelian' => $row['id_pembelian'],
            'id_barang' => $row['id_barang'],
            'harga' => $row['harga'],
            'stok_awal' => $row['stok_awal'],
            'stok_sisa' => $row['stok_sisa'],
            'nama' => $row['nama'],
            'kode' => $row['kode'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>
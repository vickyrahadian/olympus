<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT ALL DATA NO LIMIT
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

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

@$idreturbeli = $data[0][2];
@$idpemasok = $data[0][3];
@$idpembelian = $data[0][4];
@$banyakdata = sizeof($data);


if ($kode == '5557') {

    $sql = "SELECT r.*, b.nama as namabarang, b.kode as kodebarang,
            (
                SELECT COUNT(*) FROM retur_beli_detail WHERE id_returbeli = $idreturbeli
            ) as totaldata
            FROM retur_beli_detail r
            JOIN barang b ON r.id_barang = b.id_barang
            WHERE r.id_returbeli = $id";
}

if ($kode == '4444') {

    $id_barang[] = '';
    $jumlah[] = '';
    $harga[] = '';

    for ($i = 1; $i < $banyakdata; $i++) {
        $id_barang[$i] = $data[$i][0];
        $jumlah[$i] = $data[$i][1];
        $harga[$i] = $data[$i][2];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        if ($jumlah[$i] > 0) {
            $sql = "INSERT INTO `retur_beli_detail`(`id_returbeli`, `id_barang`, `harga`, `jumlah`) VALUES($idreturbeli, $id_barang[$i], $harga[$i], $jumlah[$i])";
            mysql_query($sql);
            $sql = "INSERT INTO `barang_transaksi`(`id_pemasok`, `id_kategori`, `id_pembelian`, `id_returbeli`, `id_barang`, `jumlah_keluar`, `harga`, `createdby`) VALUES($idpemasok, 3, $idpembelian, $idreturbeli, $id_barang[$i], $jumlah[$i], $harga[$i], $user)";
            mysql_query($sql);
            $sql = "UPDATE barang SET stok = stok - $jumlah[$i] WHERE id_barang = $id_barang[$i]";
            mysql_query($sql);
            $sql = "UPDATE barang_persediaan SET stok_sisa = stok_sisa - $jumlah[$i], stok_maksimal = stok_maksimal - $jumlah[$i] WHERE id_barang = $id_barang[$i] AND id_pembelian = $idpembelian";
            mysql_query($sql);            
        }
    }
    
    $sql = "SELECT r.*, b.nama as namabarang, b.kode as kodebarang, (SELECT COUNT(*) FROM retur_beli_detail WHERE id_returbeli = $idreturbeli) as totaldata
            FROM retur_beli_detail r
            JOIN barang b ON r.id_barang = b.id_barang
            WHERE r.id_returbeli = $idreturbeli";
    
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
            'id_returbelidetail' => $row['id_returbelidetail'],
            'id_returbeli' => $row['id_returbeli'],
            'id_barang' => $row['id_barang'],
            'harga' => $row['harga'],
            'jumlah' => $row['jumlah'],
            'namabarang' => $row['namabarang'],
            'kodebarang' => $row['kodebarang'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>
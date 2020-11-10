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

$id_pemasok = $data[0][3];
$cur_pos = ($hal - 1) * $lim;
$banyakdata = sizeof($data);

if ($kode == '4444') {
    $id_barang[] = '';
    $harga[] = '';
    $jumlah[] = '';

    for ($i = 1; $i < $banyakdata; $i++) {
        $id_barang[$i] = $data[$i][0];
        $harga[$i] = $data[$i][2];
        $jumlah[$i] = $data[$i][1];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        $sql = "INSERT INTO `pembelian_detail`(`id_pembelian`, `id_barang`, `harga`, `jumlah`) VALUES ($id, $id_barang[$i], $harga[$i], $jumlah[$i])";
        mysql_query($sql);
        $sql = "INSERT INTO `barang_transaksi`(`id_pemasok`, `id_kategori`, `id_pembelian`, `id_barang`, `jumlah_masuk`, `harga`, `createdby`) VALUES ($id_pemasok, 1, $id, $id_barang[$i], $jumlah[$i], $harga[$i],$user)";
        mysql_query($sql);
        $sql = "INSERT INTO barang_persediaan(`id_barang`, `id_pembelian`, `harga`, `stok_awal`, `stok_maksimal`, `stok_sisa`, createdby) VALUES ($id_barang[$i], $id, $harga[$i], $jumlah[$i], $jumlah[$i], $jumlah[$i], $user)";
        mysql_query($sql);
        
        $sql = "SELECT max(harga) as harga FROM barang_persediaan WHERE id_barang = $id_barang[$i] AND stok_sisa > 0";
        $run = mysql_query($sql); 
        $row = mysql_fetch_array($run);
        $harga_beli = $row['harga'];
        $sql = "UPDATE barang SET stok = stok + $jumlah[$i], harga_beli = $harga_beli WHERE id_barang = $id_barang[$i]";
        mysql_query($sql);			
    }

    $sql = "SELECT 
            pembelian_detail.*, barang.nama, barang.kode, 
            (
                SELECT COUNT(*)
                FROM pembelian_detail 
                WHERE id_pembelian = $id
            ) as totaldata
            FROM pembelian_detail, barang 
            WHERE pembelian_detail.id_barang = barang.id_barang
            AND id_pembelian = $id";
} else if ($kode == '5557') {

    $sql = "SELECT 
            pembelian_detail.*, barang.nama, barang.kode, 
            (
                SELECT COUNT(*)
                FROM pembelian_detail 
                WHERE id_pembelian = $id
            ) as totaldata
            FROM pembelian_detail, barang 
            WHERE pembelian_detail.id_barang = barang.id_barang
            AND id_pembelian = $id";
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
            'id_pembeliandetail' => $row['id_pembeliandetail'],
            'id_pembelian' => $row['id_pembelian'],
            'id_barang' => $row['id_barang'],
            'harga' => $row['harga'],
            'jumlah' => $row['jumlah'],
            'nama' => $row['nama'],
            'kode' => $row['kode'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>
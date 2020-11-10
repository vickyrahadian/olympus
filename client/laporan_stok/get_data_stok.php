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
@$tabel = $_GET['tabel'];

if ($hal == "" || $hal < 1) {
    $hal = 1;
}

$cur_pos = ($hal - 1) * $lim;

//VARIABLE FROM POST 

if ($kode == '5555') {
    $sql = "SELECT bs.*, b.nama, p.no_nota as notapembelian, rb.no_nota as notareturbeli, p2.no_faktur as fakturpenjualan, rj.no_nota as notareturjual,
            (
                SELECT COUNT(*) FROM barang_stok
            ) as totaldata
            FROM barang_stok bs
            JOIN barang b ON b.id_barang = bs.id_barang 
            JOIN pembelian_detail pd ON pd.id_barang = b.id_barang
            JOIN pembelian p ON pd.id_pembelian = p.id_pembelian
            JOIN retur_beli_detail rbd ON rbd.id_barang = b.id_barang
            JOIN retur_beli rb ON rb.id_returbeli = rbd.id_returbeli
            JOIN penjualan_detail p2d ON p2d.id_barang = b.id_barang
            JOIN penjualan p2 ON p2d.id_penjualan = p2.id_penjualan
            JOIN retur_jual_detail rjd ON rjd.id_barang = b.id_barang
            JOIN retur_jual rj ON rj.id_returjual = rjd.id_returjual
            WHERE b.id_barang = $id
            LIMIT $cur_pos, $lim";
}

echo $sql;

$result = mysql_query($sql);
$totalrow = mysql_num_rows($result);

if ($totalrow <= 0) {
    $json['data'][] = array(
        'totalrow' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_barangstok' => $row['id_barangstok'],
            'id_kategori' => $row['id_kategori'],
            'jumlah_masuk' => $row['jumlah_masuk'],
            'jumlah_keluar' => $row['jumlah_keluar'],
            'harga' => $row['harga'],
            'notapembelian' => $row['notapembelian'],
            'notareturbeli' => $row['notareturbeli'],
            'fakturpenjualan' => $row['fakturpenjualan'],
            'notareturjual' => $row['notareturjual'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>
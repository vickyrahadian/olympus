<?php

//1111 = SELECT AKTIF
//1112 = SELECT TIDAK AKTIF
//1113 = SELECT SEMUA BARANG
//1114 = SELECT ON LIMIT
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

if ($kode == '1114') {
    $sql = "SELECT 
                    b.*, 
                    kb.nama as namakategori,
                    bs.nama as namasatuan,
                    ifnull(SUM(jumlah_masuk), 0) as jumlahmasuk, 
                    ifnull(SUM(jumlah_keluar), 0) as jumlahkeluar, 
                    ifnull((SUM(jumlah_masuk) - SUM(jumlah_keluar)), 0) as stok,
                    (
                        SELECT COUNT(*)
                        FROM barang
                        WHERE status = 1
                    ) as totaldata
                FROM
                    barang_stok bst
                    RIGHT JOIN barang b ON bst.id_barang = b.id_barang 
                    JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
                    JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
                WHERE 
                    b.status = 1 
                GROUP BY
                    b.id_barang
                ORDER BY nama ASC";
}



$result = mysql_query($sql);
$totalrow = mysql_num_rows($result);

if ($totalrow <= 0) {
    $json['data'][] = array(
        'total_row' => 0
    );
} else {
    while ($row = mysql_fetch_array($result)) {
        $json['data'][] = array(
            'id_barang' => $row['id_barang'],
            'kode' => $row['kode'],
            'barcode' => $row['barcode'] == null ? '-' : $row['barcode'],
            'nama' => $row['nama'],
            'id_satuan' => $row['id_satuan'],
            'harga_ecer' => $row['harga_ecer'],
            'stok_terjual' => $row['stok_terjual'],
            'id_kategori' => $row['id_kategori'],
            'gambar' => $row['gambar'],
            'status' => $row['status'],
            'namakategori' => $row['namakategori'],
            'namasatuan' => $row['namasatuan'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'updateddate' => $row['updateddate'],
            'updatedby' => $row['updatedby'],
            'jumlahmasuk' => $row['jumlahmasuk'],
            'jumlahkeluar' => $row['jumlahkeluar'],
            'stok' => $row['stok'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>
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
$barcode = $data[0][3];
$nama = gantiHurufKapital($data[0][4]);
$hargaecer = $data[0][5];
$stokterjual = $data[0][6];
$idkategori = $data[0][7];
$idsatuan = $data[0][8];
$status = $data[0][9];
$gambar = $data[0][10];

if ($kode == '1111') {
    $sql = "SELECT 
            b.*, 
            kb.nama as namakategori,
            bs.nama as namasatuan,
            (
                SELECT COUNT(*)
                FROM barang
                WHERE status = 1
            ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '1112') {
    $sql = "SELECT 
            b.*, 
            kb.nama as namakategori,
            bs.nama as namasatuan,
            (
                SELECT COUNT(*)
                FROM barang
                WHERE status = 0
            ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 0
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '1113') {
    $sql = "SELECT 
            b.*, 
            kb.nama as namakategori,
            bs.nama as namasatuan,
            (
                SELECT COUNT(*)
                FROM barang
                WHERE status = 1
            ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            ORDER BY nama ASC";
} else if ($kode == '2222') {

    $last_kode = '';
    $kode_kategori = '';
    $kode_barang = '';

    //AMBIL KODE BARANG
    $sql = "
            SELECT *
            FROM barang_kategori
            WHERE id_barangkategori = $idkategori
            LIMIT 1
            ";

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $kode_kategori = $row['kode'];    

    $sql = "SELECT barang.* , barang_kategori.kode as kodekategori
            FROM barang, barang_kategori
            WHERE barang.id_kategori = barang_kategori.id_barangkategori
            AND barang.id_kategori  = $idkategori
            ORDER BY barang.kode DESC
            LIMIT 1";

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $last_kode = $row['kode'];    
    $last_kode = substr($last_kode, 4, 4);
    $last_kode = intval($last_kode);
    $last_kode++;

    if ($last_kode < 10) {
        $last_kode = '000' . $last_kode;
    } else if ($last_kode >= 10 && $last_kode < 100) {
        $last_kode = '00' . $last_kode;
    } else if ($last_kode >= 100 && $last_kode < 1000) {
        $last_kode = '0' . $last_kode;
    }

    $kode_barang = $kode_kategori . $last_kode;

    $sqlupdate = "UPDATE 
                    barang 
                SET 
                    barcode = '$barcode',
                    kode = '$kode_barang',
                    nama = '$nama', 
                    id_satuan =  $idsatuan,
                    harga_ecer = $hargaecer, 
                    id_kategori = $idkategori, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user,
                    gambar = '$gambar' 
                WHERE 
                    id_barang = $id    
                ";

    mysql_query($sqlupdate);

    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
                1 as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            ORDER BY updateddate DESC                
            LIMIT 1";
    
} else if ($kode == '3333') {
    $sqldelete = "UPDATE barang 
                SET 
                    status = 0, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_barang = $id";

    mysql_query($sqldelete);

    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
            (
                SELECT COUNT(*)
                FROM barang
                WHERE status = 1
            ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '4444') {
    $last_kode = '';
    $kode_kategori = '';
    $kode_barang = '';

    //AMBIL KODE BARANG
    $sql = "
            SELECT *
            FROM barang_kategori
            WHERE id_barangkategori  = $idkategori
            LIMIT 1
            ";

    $result = mysql_query($sql);

    while ($row = mysql_fetch_array($result)) {
        $kode_kategori = $row['kode'];
    }

    $sql = "SELECT barang . * , barang_kategori.kode as kodekategori
            FROM barang, barang_kategori
            WHERE barang.id_kategori = barang_kategori.id_barangkategori
            AND barang.id_kategori = $idkategori
            ORDER BY barang.kode DESC
            LIMIT 1";

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $last_kode = $row['kode'];    

    $last_kode = substr($last_kode, 4, 4);
    $last_kode = intval($last_kode);
    $last_kode++;

    if ($last_kode < 10) {
        $last_kode = '000' . $last_kode;
    } else if ($last_kode >= 10 && $last_kode < 100) {
        $last_kode = '00' . $last_kode;
    } else if ($last_kode >= 100 && $last_kode < 1000) {
        $last_kode = '0' . $last_kode;
    }

    $kode_barang = $kode_kategori . $last_kode;
    $sqlinsert = "INSERT INTO `barang`(`kode`, `barcode`, `nama`, `harga_ecer`, `stok_terjual`, `id_kategori`, `id_satuan`, `harga_beli`, `stok`, `status`, `createddate`, `createdby`, `gambar`) VALUES ('$kode_barang', '$barcode', '$nama', $hargaecer, 0, $idkategori, $idsatuan, 0, 0, 1, CURRENT_TIMESTAMP, $user, '$gambar')"; 
    mysql_query($sqlinsert);

    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
                1 as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            ORDER BY createddate DESC                
            LIMIT 1";
    
} else if ($kode == '5555') {
    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
                (
                    SELECT COUNT(*)
                    FROM barang
                    WHERE status = 1
                    AND
                    (    
                        nama LIKE '%$search%'
                        OR
                        kode LIKE '%$search%'
                        OR
                        barcode LIKE '%$search%'
                    )
                ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 1 
            AND
            (
                b.nama LIKE '%$search%'
                OR
                b.kode LIKE '%$search%'
                OR
                b.barcode LIKE '%$search%'
            )
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '5556') {
    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
                (
                    SELECT COUNT(*)
                    FROM barang
                    WHERE status = 0
                    AND
                    (    
                        nama LIKE '%$search%'
                        OR
                        kode LIKE '%$search%'
                        OR
                        barcode LIKE '%$search%'
                    )
                ) as totaldata
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 0
            AND
            (
                b.nama LIKE '%$search%'
                OR
                b.kode LIKE '%$search%'
                OR
                b.barcode LIKE '%$search%'
            )
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
    
} else if ($kode == '7777') {
    $sqlactive = "UPDATE barang 
                SET 
                    status = 1, 
                    updateddate = CURRENT_TIMESTAMP, 
                    updatedby = $user 
                WHERE id_barang = $id";

    $result = mysql_query($sqlactive);

    $sql = "SELECT 
                b.*, 
                kb.nama as namakategori,
                bs.nama as namasatuan,
                (
                    SELECT COUNT(*)
                    FROM barang
                    WHERE status = 0
                ) as totaldata  
            FROM barang b 
            JOIN barang_kategori kb ON b.id_kategori = kb.id_barangkategori 
            JOIN barang_satuan bs ON b.id_satuan = bs.id_barangsatuan 
            WHERE b.status = 0 
            ORDER BY nama ASC                
            LIMIT $cur_pos, $lim";
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
            'stok' => $row['stok'],
            'harga_beli' => $row['harga_beli'],
            'createddate' => $row['createddate'],
            'createdby' => $row['createdby'],
            'updateddate' => $row['updateddate'],
            'updatedby' => $row['updatedby'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}

echo json_encode($json); 
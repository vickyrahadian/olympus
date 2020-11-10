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

$id_pelanggan = $data[0][3];
$cur_pos = ($hal - 1) * $lim;
$banyakdata = sizeof($data);

if ($kode == '4444') {
    
    $sql = "SELECT pemb.*, pema.nama, pema.alamat, pema.kota, pema.kodepos , 1 as totaldata 
            FROM penjualan pemb, pelanggan pema
            WHERE pemb.id_pelanggan = pema.id_pelanggan 
            ORDER BY createddate DESC
            LIMIT 1";
    $run = mysql_query($sql);
    $row = mysql_fetch_array($run);
    $id_penjualan = $row['id_penjualan'];
    $biaya_kirim = $row['biaya_kirim'];
    $subtotal = $row['subtotal'];
    $total = $row['total'];
    $bayar = $row['bayar'];
    $status_pembayaran = $row['status_pembayaran'];
    $hpp = 0;
    
    $id_barang[] = '';
    $harga[] = '';
    $jumlah[] = '';

    for ($i = 1; $i < $banyakdata; $i++) {
        $id_barang[$i] = $data[$i][0];
        $harga[$i] = $data[$i][2];
        $jumlah[$i] = $data[$i][1];
    }

    for ($i = 1; $i < $banyakdata; $i++) {
        $sql = "INSERT INTO barang_transaksi(id_pelanggan, id_kategori, id_penjualan, id_barang, jumlah_keluar, harga, createdby) VALUES ($id_pelanggan, 2, $id, $id_barang[$i], $jumlah[$i], $harga[$i], $user)";
        mysql_query($sql);
        
        $sql = "SELECT max(harga) as harga FROM barang_persediaan WHERE id_barang = $id_barang[$i] AND stok_sisa > 0";
        $run = mysql_query($sql); 
        $row = mysql_fetch_array($run);
        $harga_beli = $row['harga'];
        $sql = "UPDATE barang SET stok = stok - $jumlah[$i], harga_beli = $harga_beli WHERE id_barang = $id_barang[$i]";
        mysql_query($sql); 

        //persediaan

        $jumlahjual = $jumlah[$i];
        $idbarang = $id_barang[$i];
        
        $position = 0;
        while ($jumlahjual > 0) {
            $sql = "SELECT * FROM barang_persediaan WHERE id_barang = $idbarang AND stok_sisa > 0 ORDER BY id_barangpersediaan ASC LIMIT 1";
            $query = mysql_query($sql);

            $id_barangpersediaan = 0;
            $stok_maks = 0;
            $stok_sisa = 0;

            while ($row1 = mysql_fetch_array($query)) {
                $id_barangpersediaan = $row1['id_barangpersediaan'];
                $stok_maks = $row1['stok_maksimal'];
                $stok_sisa = $row1['stok_sisa'];
                $hargas =  $row1['harga'];
            }

            if ($stok_sisa >= $jumlahjual) {   
                mysql_query("INSERT INTO `penjualan_detail`(`id_penjualan`, `id_barang`, `id_persediaan`, `harga`, `jumlah`) VALUES ($id, $id_barang[$i], $id_barangpersediaan, $harga[$i], $jumlahjual)");           
		//$run = mysql_query($sql);
                mysql_query("UPDATE barang_persediaan SET stok_sisa = stok_sisa - $jumlahjual WHERE id_barangpersediaan = $id_barangpersediaan");
		//$run = mysql_query($sql);
		$hpp += ($hargas * $jumlahjual);
                $jumlahjual = 0;
            } else {
                mysql_query("INSERT INTO `penjualan_detail`(`id_penjualan`, `id_barang`, `id_persediaan`, `harga`, `jumlah`) VALUES ($id, $id_barang[$i], $id_barangpersediaan, $harga[$i], $stok_sisa)");   
		//$run = mysql_query($sql);
                mysql_query("UPDATE barang_persediaan SET stok_sisa = 0 WHERE id_barangpersediaan = $id_barangpersediaan");
		//$run = mysql_query($sql);
		$hpp += ($hargas * $stok_sisa);		
                $jumlahjual -= $stok_sisa;
                
            }   
            $position++;
        }
    }   
    
    //accounting
    if($status_pembayaran == 1){
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_penjualan, NOW(), $subtotal, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (5, $id_penjualan, NOW(), 0, $subtotal, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    } else {
        $sisadana = $bayar - $biaya_kirim;
        if($sisadana == 0){
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (2, $id_penjualan, NOW(), $subtotal, 0, $user)";
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (5, $id_penjualan, NOW(), 0, $subtotal, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        } else {
            $sisa = $subtotal - $sisadana;
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_penjualan, NOW(), $sisadana, 0, $user)";
            mysql_query($sqldeb);
            $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (2, $id_penjualan, NOW(), $sisa, 0, $user)";           
            $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (5, $id_penjualan, NOW(), 0, $subtotal, $user)";
            mysql_query($sqldeb);
            mysql_query($sqlkre);
        }
    }
    
    $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (11, $id_penjualan, NOW(), $hpp, 0, $user)";
    $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (3, $id_penjualan, NOW(), 0, $hpp, $user)";
    mysql_query($sqldeb);
    mysql_query($sqlkre);

    //jurnal biaya kirim
    if($biaya_kirim > 0){
        $sqldeb = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (1, $id_penjualan, NOW(), $biaya_kirim, 0, $user)";
        $sqlkre = "INSERT INTO `jurnal_umum`(`id_kodeakun`, `id_penjualan`, `tanggal`, `debit`, `kredit`, `createdby`) VALUES (7, $id_penjualan, NOW(), 0, $biaya_kirim, $user)";
        mysql_query($sqldeb);
        mysql_query($sqlkre);
    }
    //end accounting

    $sql = "SELECT penjualan_detail.*, SUM(jumlah) as jumlahs, barang.nama, barang.kode, 

            (
                    SELECT COUNT(DISTINCT id_barang) FROM penjualan_detail WHERE id_penjualan = $id  
            ) as totaldata
            FROM penjualan_detail, barang 
            WHERE penjualan_detail.id_barang = barang.id_barang
            AND id_penjualan = $id GROUP BY id_barang";
    
} else if ($kode == '5557') {
    $sql = "SELECT penjualan_detail.*, SUM(jumlah) as jumlahs, barang.nama, barang.kode, 

            (
                    SELECT COUNT(DISTINCT id_barang) FROM penjualan_detail WHERE id_penjualan = $id  
            ) as totaldata
            FROM penjualan_detail, barang 
            WHERE penjualan_detail.id_barang = barang.id_barang
            AND id_penjualan = $id GROUP BY id_barang";
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
            'id_penjualandetail' => $row['id_penjualandetail'],
            'id_penjualan' => $row['id_penjualan'],
            'id_barang' => $row['id_barang'],
            'harga' => $row['harga'],
            'jumlah' => $row['jumlahs'],
            'nama' => $row['nama'],
            'kode' => $row['kode'],
            'totalrow' => $totalrow,
            'totaldata' => $row['totaldata']
        );
    }
}
echo json_encode($json);
?>